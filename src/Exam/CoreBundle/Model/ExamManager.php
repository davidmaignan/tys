<?php

/*
 * This file is part of the ExamCoreBundle package.
 *
 * (c) Testyrskills.com <http://www.testyrskills.com/>
 *
 */


/**
 * Abstract Exam Manager implementation which can be used as base class for your
 * concrete manager.
 *
 * @author David Maignan <davidmaignan@gmail.com>
 */
namespace Exam\CoreBundle\Model;

class ExamManager implements ExamManagerInterface
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
    public function createExam()
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
}