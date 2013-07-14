<?php

/*
 * This file is part of the CoreAnswerBundle package.
 *
 * (c) Testyrskills.com <http://www.Testyrskills.com/>
 *
 */

namespace Security\AuthenticateBundle\Context;

use Behat\MinkExtension\Context\RawMinkContext;
use Behat\MinkExtension\Context\MinkContext;
use Behat\Gherkin\Node\TableNode;
use Behat\Symfony2Extension\Context\KernelAwareInterface;
use Symfony\Component\HttpKernel\KernelInterface;

use Security\AuthenticateBundle\Entity\User;

//
// Require 3rd-party libraries here:
//
require_once 'PHPUnit/Autoload.php';
require_once 'PHPUnit/Framework/Assert/Functions.php';

/*
 * @author David Maignan <davidmaignan@gmail.com>
 */
class AuthenticateContext extends MinkContext implements KernelAwareInterface
{
    /**
     * @var KernelInterface Kernel
     */
    private $kernel;

    /**
     * @var array
     */
    private $dictionary = array();

    /**
     * {@inheritdoc}
     */
    public function setKernel(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }
    
    /**
     * Get service from container
     *
     * @param string $serviceName Service name
     *
     * @return mixed
     */
    private function getService($serviceName)
    {
        return $this->kernel->getContainer()->get($serviceName);
    }
    
}