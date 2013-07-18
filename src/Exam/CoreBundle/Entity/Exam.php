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
     * @ORM\OneToMany(targetEntity="Exam\CoreBundle\Entity\ExamCriteria", mappedBy="exam")
     */
    private $examCandidates;
    
    /**
     * @ORM\OneToOne(targetEntity="Exam\CoreBundle\Entity\ExamCriteria", mappedBy="exam", cascade={"persist"} ) )
     */
    private $examCriteria;
    
    /**
     * @ORM\ManyToOne(targetEntity="Security\AuthenticateBundle\Entity\User")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $owner;
    
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
        $this->examCandidates = new \Doctrine\Common\Collections\ArrayCollection();
        
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
     * Add examCandidate
     *
     * @param \Exam\CoreBundle\Entity\ExamCandidate $examCandidate
     * @return ArrayCollection
     */
    public function addExamCandidate(\Exam\CoreBundle\Entity\ExamCandidate $examCandidate)
    {
        $this->examCandidates[] = $examCandidate;
    
        return $this;
    }

    /**
     * Remove examCandidate
     *
     * @param \Exam\CoreBundle\Entity\ExamCandidate $examCandidate
     */
    public function removeExamCandidate(\Exam\CoreBundle\Entity\ExamCandidate $examCandidate)
    {
        $this->examCandidates->removeElement($examCandidate);
    }
    
    /**
     * Get examCandidates
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getExamCandidates()
    {
        return $this->examCandidates;
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
