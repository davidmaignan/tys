<?php

namespace Exam\CoreBundle\Entity;

interface ExamInterface {
    
    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt);
    
    /**
     * @return \DateTime
     */
    public function getCreatedAt();
    
    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt);
    
    /**
     * @return \DateTime
     */
    public function getUpdatedAt();
    
    /**
     * @param \Exam\CoreBundle\Entity\ExamCandidateInterface $examCandidate
     */
    public function addExamCandidate(\Exam\CoreBundle\Entity\ExamCandidateInterface $examCandidate);
    
    /**
     * @param \Exam\CoreBundle\Entity\ExamCandidateInterface $examCandidate
     */
    public function removeExamCandidate(\Exam\CoreBundle\Entity\ExamCandidateInterface $examCandidate);
    
    /**
     * @return \Doctrine\Commons\Collections\ArrayCollection
     */
    public function getExamCandidates();
    
    /**
     * @param \Security\AuthenticateBundle\Entity\User $owner
     */
    public function setOwner(\Security\AuthenticateBundle\Entity\User $owner = null);
    
    /**
     * @return \Security\AuthenticateBundle\Entity\User
     */
    public function getOwner();
    
    /**
     * @param \Exam\CoreBundle\Entity\ExamCriteriaInterface $examCriteria
     */
    public function setExamCriteria(\Exam\CoreBundle\Entity\ExamCriteriaInterface $examCriteria = null);
    
    /**
     * @return Exam\CoreBundle\Entity\ExamCriteriaInterface
     */
    public function getExamCriteria();
}
