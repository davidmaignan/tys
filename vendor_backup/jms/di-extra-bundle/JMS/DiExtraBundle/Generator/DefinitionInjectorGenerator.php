<?php

/*
 * Copyright 2011 Johannes M. Schmitt <schmittjoh@gmail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace JMS\DiExtraBundle\Generator;

use CG\Generator\Writer;
use Symfony\Component\DependencyInjection\Parameter;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Definition;

/**
 * Generates lightweight code for injecting a single definition.
 *
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 */
class DefinitionInjectorGenerator
{
    private $nameGenerator;
    private $inlinedDefinitions;

    public function __construct()
    {
        $this->nameGenerator = new NameGenerator();
        $this->inlinedDefinitions = new \SplObjectStorage();
    }

    public function generate(Definition $def)
    {
        $writer = new Writer();

        $writer
            ->writeln('<?php')
            ->writeln('/**')
            ->writeln(' * This code has been auto-generated by the JMSDiExtraBundle.')
            ->writeln(' *')
            ->writeln(' * Manual changes to it will be lost.')
            ->writeln(' */')
            ->writeln('return function($container) {')
            ->indent()
        ;

        if ($file = $def->getFile()) {
            $writer->writeln('require_once '.var_export($file, true).';');

            require_once $file;
        }

        foreach ($this->getInlineDefinitions($def) as $inlineDef) {
            $name = $this->nameGenerator->nextName();
            $this->inlinedDefinitions[$inlineDef] = $name;

            $writer->writeln('$'.$name.' = new \\'.$inlineDef->getClass().$this->dumpArguments($inlineDef->getArguments()).';');
        }

        $writer->writeln('$instance = new \\'.$def->getClass().$this->dumpArguments($def->getArguments()).';');

        foreach ($def->getMethodCalls() as $call) {
            list($method, $arguments) = $call;
            $writer->writeln('$instance->'.$method.$this->dumpArguments($arguments).';');
        }

        $ref = new \ReflectionClass($def->getClass());
        foreach ($def->getProperties() as $property => $value) {
            $refProperty = $this->getReflectionProperty($ref, $property);

            if ($refProperty->isPublic()) {
                $writer->writeln('$instance->'.$property.' = '.$this->dumpValue($value).';');
            } else {
                $writer
                    ->writeln(sprintf("\$refProperty = new \ReflectionProperty(%s, %s);", var_export($refProperty->getDeclaringClass()->getName(), true), var_export($property, true)))
                    ->writeln('$refProperty->setAccessible(true);')
                    ->writeln('$refProperty->setValue($instance, '.$this->dumpValue($value).');')
                ;
            }
        }

        if (method_exists($def, 'getInitMethod') && $def->getInitMethod()) {
            $writer->writeln('$instance->'.$def->getInitMethod().'();');
        }

        $writer
            ->writeln('return $instance;')
            ->outdent()
            ->writeln('};')
        ;

        return $writer->getContent();
    }

    private function getReflectionProperty($ref, $property)
    {
        $origClass = $ref->getName();
        while (!$ref->hasProperty($property) && false !== $ref = $ref->getParentClass());

        if (!$ref->hasProperty($property)) {
            throw new \RuntimeException(sprintf('Could not find property "%s" anywhere in class "%s" or one of its parents.', $property, $origName));
        }

        return $ref->getProperty($property);
    }

    private function getInlineDefinitions(Definition $def)
    {
        $defs = new \SplObjectStorage();
        $this->getDefinitionsFromArray($def->getArguments(), $defs);
        $this->getDefinitionsFromArray($def->getMethodCalls(), $defs);
        $this->getDefinitionsFromArray($def->getProperties(), $defs);

        return $defs;
    }

    private function getDefinitionsFromArray(array $a, \SplObjectStorage $defs)
    {
        foreach ($a as $k => $v) {
            if ($v instanceof Definition) {
                $defs->attach($v);
            } else if (is_array($v)) {
                $this->getDefinitionsFromArray($v, $defs);
            }
        }
    }

    private function dumpArguments(array $arguments)
    {
        $code = '(';

        $first = true;
        foreach ($arguments as $argument) {
            if (!$first) {
                $code .= ', ';
            }
            $first = false;

            $code .= $this->dumpValue($argument);
        }

        return $code.')';
    }

    private function dumpValue($value)
    {
        if (is_array($value)) {
            $code = 'array(';

            $first = true;
            foreach ($value as $k => $v) {
                if (!$first) {
                    $code .= ', ';
                }
                $first = false;

                $code .= sprintf('%s => %s', var_export($k, true), $this->dumpValue($v));
            }

            return $code.')';
        } else if ($value instanceof Reference) {
            if ('service_container' === (string) $value) {
                return '$container';
            }

            return sprintf('$container->get(%s, %d)', var_export((string) $value, true), $value->getInvalidBehavior());
        } else if ($value instanceof Parameter) {
            return sprintf('$container->getParameter(%s)', var_export((string) $value, true));
        } else if (is_scalar($value) || null === $value) {
            // we do not support embedded parameters
            if (is_string($value) && '%' === $value[0] && '%' !== $value[1]) {
                return sprintf('$container->getParameter(%s)', var_export(substr($value, 1, -1), true));
            }

            return var_export($value, true);
        } else if ($value instanceof Definition) {
            return sprintf('$%s', $this->inlinedDefinitions[$value]);
        }

        throw new \RuntimeException(sprintf('Found unsupported value of type %s during definition injector generation: "%s"', gettype($value), json_encode($value)));
    }
}