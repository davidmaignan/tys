<?php

/*
 * This file is part of the QuestionCreateBundle package.
 *
 * (c) Testyrskills.com <http://www.Testyrskills.com/>
 *
 */

namespace Core\SectionBundle\Model;


/**
 * Abstract Section Manager implementation which can be used as base class for your
 * concrete manager.
 *
 * @author David Maignan <davidmaignan@gmail.com>
 */
abstract class SectionManager
{

    /**
     * Constructor.
     *
     */
    public function __construct()
    {
        
    }

    /**
     * Returns an empty section instance
     *
     * @return QuestionInterface
     */
    public function createSection()
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
