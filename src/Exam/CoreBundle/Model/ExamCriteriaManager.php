<?php

/*
 * This file is part of the ExamCoreBundle package.
 *
 * (c) Testyrskills.com <http://www.testyrskills.com/>
 *
 */

namespace Exam\CoreBundle\Model;


/**
 * Abstract ExamCriteria Manager implementation which can be used as base class for your
 * concrete manager.
 *
 * @author David Maignan <davidmaignan@gmail.com>
 */
abstract class ExamCriteriaManager implements ExamCriteriaManagerInterface
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
     * @return ExamCriteriaInterface
     */
    public function createExamCriteria()
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
