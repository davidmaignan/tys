<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Exam\CoreBundle\Entity;
/**
 *
 * @author davidmaignan
 */
interface ExamCandidateInterface {
    /**
     * @param integer $completion
     */
    public function setCompletion($completion);
    
    /**
     * @return integer
     */
    public function getCompletion();
    
    /**
     * @param \DateTime $startedAt
     */
    public function setStartedAt(\DateTime $startedAt);
    
    /**
     * @return \DateTime
     */
    public function getStartedAt();
    
    /**
     * @param boolean $completed
     */
    public function setCompleted($completed);
    
    /**
     * @return boolean
     */
    public function getCompleted();
    
    /**
     * @param \Exam\CoreBundle\Entity\ExamInterface $exam
     */
    public function setExam(\Exam\CoreBundle\Entity\ExamInterface $exam = null);
    
    /**
     * @return \Exam\CoreBundle\Entity\ExamInterface
     */
    public function getExam();
    
    /**
     * @param \Security\AuthenticateBundle\Entity\User $candidate
     */
    public function setCandidate(\Security\AuthenticateBundle\Entity\User $candidate = null);
    
    /**
     * @return \Security\AuthenticateBundle\Entity\User
     */
    public function getCandidate();
}

