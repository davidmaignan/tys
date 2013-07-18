<?php

/**
 * @copyright 2013 testyrskills.com
 */
namespace Exam\CoreBundle\Entity;

/**
 * ExamCandidate class
 *
 * @author David Maignan <davidmaignan@gmail.com>
 */

use Doctrine\ORM\Mapping as ORM;

/**
 * Exam\CoreBundle\Entity\ExamCandidate
 *
 * @ORM\Table(name="exam_candidate")
 * @ORM\Entity(repositoryClass="Exam\CoreBundle\Entity\ExamCandidate")
 * @ORM\HasLifecycleCallbacks()
 */
class ExamCandidate {
    
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Exam\CoreBundle\Entity\Exam", inversedBy="examCandidates")
     */
    private $exam;
    
    /**
     * @ORM\ManyToOne(targetEntity="\Security\AuthenticateBundle\Entity\User", inversedBy="examCandidates")
     */
    private $candidate;
    
    /**
     * @var integer $completion
     *
     * @ORM\Column(name="completion", type="integer", nullable=true)
     */
    private $completion;
    
    /**
     * @var datetime $updatedAt
     * @ORM\Column(name="updatedAt", type="datetime") 
     */
    private $startedAt;
    
    /**
     * @var boolean $completed
     * 
     * @ORM\Column(name="completed", type="boolean", nullable=false)
     *
     */
    private $completed = false;
    
    public function __construct()
    {
        
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set completion
     *
     * @param integer $completion
     * @return ExamCandidate
     */
    public function setCompletion($completion)
    {
        $this->completion = $completion;

        return $this;
    }

    /**
     * Get completion
     *
     * @return integer 
     */
    public function getCompletion()
    {
        return $this->completion;
    }

    /**
     * Set startedAt
     *
     * @param \DateTime $startedAt
     * @return ExamCandidate
     */
    public function setStartedAt($startedAt)
    {
        $this->startedAt = $startedAt;

        return $this;
    }

    /**
     * Get startedAt
     *
     * @return \DateTime 
     */
    public function getStartedAt()
    {
        return $this->startedAt;
    }

    /**
     * Set completed
     *
     * @param boolean $completed
     * @return ExamCandidate
     */
    public function setCompleted($completed)
    {
        $this->completed = $completed;

        return $this;
    }

    /**
     * Get completed
     *
     * @return boolean 
     */
    public function getCompleted()
    {
        return $this->completed;
    }

    /**
     * Set exam
     *
     * @param \Exam\CoreBundle\Entity\Exam $exam
     * @return ExamCandidate
     */
    public function setExam(\Exam\CoreBundle\Entity\Exam $exam = null)
    {
        $this->exam = $exam;

        return $this;
    }

    /**
     * Get exam
     *
     * @return \Exam\CoreBundle\Entity\Exam 
     */
    public function getExam()
    {
        return $this->exam;
    }

    /**
     * Set candidate
     *
     * @param \Security\AuthenticateBundle\Entity\User $candidate
     * @return ExamCandidate
     */
    public function setCandidate(\Security\AuthenticateBundle\Entity\User $candidate = null)
    {
        $this->candidate = $candidate;

        return $this;
    }

    /**
     * Get candidate
     *
     * @return \Security\AuthenticateBundle\Entity\User 
     */
    public function getCandidate()
    {
        return $this->candidate;
    }
}
