<?php

/*
 * This file is part of the CoreAnswerBundle package.
 *
 * (c) Testyrskills.com <http://www.testyrskills.com/>
 *
 */

namespace Core\AnswerBundle\Model;

use Core\AnswerBundle\Doctrine\AnswerManagerInterface;


/**
 * Abstract Answer Manager implementation
 *
 * @author David Maignan <davidmaignan@gmail.com>
 */
abstract class AnswerManager implements AnswerManagerInterface
{

    /**
     * Constructor.
     *
     */
    public function __construct()
    {
        
    }

    /**
     * Returns an empty answer instance
     *
     * @return AnswerInterface
     */
    public function createAnswer()
    {
        $class = $this->getClass();
        $question = new $class;
        
        return $question;
    }
    

    /**
     * {@inheritDoc}
     */
    public function supportsClass($class)
    {
        return $class === $this->getClass();
    }
}