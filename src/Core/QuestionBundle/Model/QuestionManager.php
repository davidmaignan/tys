<?php

/*
 * This file is part of the QuestionCreateBundle package.
 *
 * (c) Testyrskills.com <http://www.Testyrskills.com/>
 *
 */

namespace Question\CreateBundle\Model;


/**
 * Abstract Question Manager implementation which can be used as base class for your
 * concrete manager.
 *
 * @author David Maignan <davidmaignan@gmail.com>
 */
abstract class QuestionManager implements QuestionManagerInterface
{

    /**
     * Constructor.
     *
     */
    public function __construct()
    {
        
    }

    /**
     * Returns an empty question instance
     *
     * @return QuestionInterface
     */
    public function createQuestion()
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
