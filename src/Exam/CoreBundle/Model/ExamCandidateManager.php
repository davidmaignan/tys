<?php
/*
 * This file is part of the ExamCoreBundle package.
 *
 * (c) Testyrskills.com <http://www.testyrskills.com/>
 *
 */
namespace Exam\CoreBundle\Model;

/**
 * Abstract Exam Candidate implementation which can be used as base class for your
 * concrete manager.
 *
 * @author David Maignan <davidmaignan@gmail.com>
 */

class ExamCandidateManager {
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
    public function createExamCandidate()
    {
        $class         = $this->getClass();
        $examCandidate = new $class;
        
        return $examCandidate;
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

