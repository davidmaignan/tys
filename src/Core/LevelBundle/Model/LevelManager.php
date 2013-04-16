<?php

/*
 * This file is part of the CoreAnswerBundle package.
 *
 * 2013 (c) Testyrskills.com <http://www.testyrskills.com/>
 *
 */

namespace Core\LevelBundle\Model;

/**
 * Abstract Level Manager implementation
 *
 * @author David Maignan <davidmaignan@gmail.com>
 */
abstract class LevelManager 
{
    /**
     * Constructor.
     *
     */
    public function __construct()
    {
        
    }

    /**
     * Returns an empty user instance
     *
     * @return LevelInterface
     */
    public function createLevel()
    {
        $class = $this->getClass();
        $user = new $class;

        return $user;
    }

    /**
     * {@inheritDoc}
     */
    public function supportsClass($class)
    {
        return $class === $this->getClass();
    }
}
