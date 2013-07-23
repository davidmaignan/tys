<?php

/*
 * This file is part of the CoreAnswerBundle package.
 *
 * 2013 (c) Testyrskills.com <http://www.testyrskills.com/>
 *
 */

namespace Exam\CoreBundle\Model;

/**
 * Abstract CriteriaQUesion Manager implementation which can be used as base class for your
 * concrete manager.
 *
 * @author David Maignan <davidmaignan@gmail.com>
 */

class CriteriaQuestionManager implements CriteriaQuestionManagerInterface
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
     * @return ExamInterface
     */
    public function createCriteriaQuestion()
    {
        $class = $this->getClass();
        $examCriteria = new $class;
        
        return $examCriteria;
    }
    

    /**
     * {@inheritDoc}
     */
    public function supportsClass($class)
    {
        return $class === $this->getClass();
    }
    
    /**
     * {@inheritDoc}
     */
    public function getClass()
    {
        return $this->class;
    }
}