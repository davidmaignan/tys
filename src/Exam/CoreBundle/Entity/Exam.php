<?php

/**
 *  Exam Bundle 
 */

namespace Exam\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\Validator\Constraints as Assert;


/**
 * Exam\CoreBundle\Entity\Exam
 *
 * @ORM\Table(name="exam")
 * @ORM\Entity(repositoryClass="Exam\CoreBundle\Entity\ExamRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Exam implements ExamInterface {
    
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\ManyToMany(targetEntity="Security\AuthenticateBundle\Entity\User", inversedBy="exams")
     * @ORM\JoinTable(name="exam_candidates")
     */
    private $candidates;
    
    /**
     * @ORM\OneToOne(targetEntity="Exam\CoreBundle\Entity\ExamCriteria", mappedBy="exam" )
     */
    private $examCriteria;
    
    /**
     * @ORM\ManyToOne(targetEntity="Security\AuthenticateBundle\Entity\User")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $owner;
    
    /**
     * @ORM\ManyToMany(targetEntity="Core\QuestionBundle\Entity\Question", inversedBy="exams", cascade={"persist"})
     * @ORM\JoinTable(name="exam_questions")
     */
    private $questions;
    
    /**
     * @var datetime $createdAt
     * @ORM\Column(name="createdAt", type="datetime") 
     */
    private $createdAt;
    
    /**
     * @var datetime $updatedAt
     * @ORM\Column(name="updatedAt", type="datetime") 
     */
    private $updatedAt;
    
    /**
     * Constructor 
     */
    public function __construct() {
        $this->questions = new ArrayCollection();
        $this->candidates = new ArrayCollection();
        
        $this->setCreatedAt(new \DateTime());
        $this->setUpdatedAt(new \DateTime());
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Exam
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Exam
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    
        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Add candidate
     *
     * @param Security\AuthenticateBundle\Entity\User $candidate
     * @return candidates
     */
    public function addCandidate(\Security\AuthenticateBundle\Entity\User $candidate)
    {
        $this->candidates[] = $candidate;
    
        return $this;
    }

    /**
     * Remove questions
     *
     * @param Core\QuestionBundle\Entity\Question $questions
     */
    public function removeCandidate(\Security\AuthenticateBundle\Entity\User $candidate)
    {
        $this->candidates->removeElement($candidate);
    }

    /**
     * Get candidates
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getCandidates()
    {
        return $this->candidates;
    }
    
    
    /**
     * Add questions
     *
     * @param Core\QuestionBundle\Entity\Question $questions
     * @return Exam
     */
    public function addQuestion(\Core\QuestionBundle\Entity\Question $questions)
    {
        $this->questions[] = $questions;
    
        return $this;
    }

    /**
     * Remove questions
     *
     * @param Core\QuestionBundle\Entity\Question $questions
     */
    public function removeQuestion(\Core\QuestionBundle\Entity\Question $questions)
    {
        $this->questions->removeElement($questions);
    }

    /**
     * Get questions
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getQuestions()
    {
        return $this->questions;
    }


    /**
     * Set candidate
     *
     * @param Security\AuthenticateBundle\Entity\User $candidate
     * @return Exam
     */
    public function setCandidate(\Security\AuthenticateBundle\Entity\User $candidate = null)
    {
        $this->candidate = $candidate;
    
        return $this;
    }

    /**
     * Get candidate
     *
     * @return Security\AuthenticateBundle\Entity\User 
     */
    public function getCandidate()
    {
        return $this->candidate;
    }


    /**
     * Set owner
     *
     * @param Security\AuthenticateBundle\Entity\User $owner
     * @return Exam
     */
    public function setOwner(\Security\AuthenticateBundle\Entity\User $owner = null)
    {
        $this->owner = $owner;
    
        return $this;
    }

    /**
     * Get owner
     *
     * @return Security\AuthenticateBundle\Entity\User 
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set criteria
     *
     * @param Exam\CoreBundle\Entity\ExamCriteria $criteria
     * @return Exam
     */
    public function setCriteria(\Exam\CoreBundle\Entity\ExamCriteria $criteria = null)
    {
        $this->criteria = $criteria;
    
        return $this;
    }

    /**
     * Get criteria
     *
     * @return Exam\CoreBundle\Entity\ExamCriteria 
     */
    public function getCriteria()
    {
        return $this->criteria;
    }

    /**
     * Set examCriteria
     *
     * @param Exam\CoreBundle\Entity\ExamCriteria $examCriteria
     * @return Exam
     */
    public function setExamCriteria(\Exam\CoreBundle\Entity\ExamCriteria $examCriteria = null)
    {
        $this->examCriteria = $examCriteria;
    
        return $this;
    }

    /**
     * Get examCriteria
     *
     * @return Exam\CoreBundle\Entity\ExamCriteria 
     */
    public function getExamCriteria()
    {
        return $this->examCriteria;
    }
    
    public function __toString()
    {
        return __CLASS__;
    }
}