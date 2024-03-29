<?php
// src/Acme/UserBundle/Entity/User.php

namespace Security\AuthenticateBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;
use Core\QuestionBundle\Entity\Question;

use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\MinLength;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Exam\CoreBundle\Entity\Exam;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="Security\AuthenticateBundle\Entity\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
     /**
     * @var integer $confirmed
     *
     * @ORM\Column(name="confirmed", type="boolean")
     */
    protected $confirmed;
    
    /**
     * @ORM\OneToMany(targetEntity="Core\QuestionBundle\Entity\Question", mappedBy="user", cascade={"persist"})
     */
    protected $questions;
    
    /**
     * @ORM\OneToMany(targetEntity="Core\CommentBundle\Entity\Comment", mappedBy="user", cascade={"persist"})
     */
    protected $comments;

    /**
     * @ORM\OneToMany(targetEntity="Shop\OrderBundle\Entity\Order2", mappedBy="user")
     */
    protected $orders;   
    
    /**
     * @ORM\OneToMany(targetEntity="Exam\CoreBundle\Entity\ExamCandidate", mappedBy="candidate")
     */
    private $examCandidates;

    public function __construct()
    {
        parent::__construct();
        // your own logic
        $this->setConfirmed(false);
        
        $this->questions      = new ArrayCollection();
        $this->orders         = new ArrayCollection();
        $this->examCandidates = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set confirmed
     *
     * @param boolean $confirmed
     * @return User
     */
    public function setConfirmed($confirmed)
    {
        $this->confirmed = $confirmed;
    
        return $this;
    }

    /**
     * Get confirmed
     *
     * @return boolean 
     */
    public function getConfirmed()
    {
        return $this->confirmed;
    }
    
    /**
     * Add questions
     *
     * @param Core\QuestionBundle\Entity\Question $questions
     * @return Type
     */
    public function addQuestion(Question $questions)
    {
        $this->questions[] = $questions;
        return $this;
    }

    /**
     * Remove questions
     *
     * @param $questions
     */
    public function removeQuestion(Question $questions)
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
     * Add orders
     *
     * @param Shop\OrderBundle\Entity\Order $orders
     * @return User
     */
    public function addOrder(\Shop\OrderBundle\Entity\Order2 $orders)
    {
        $this->orders[] = $orders;
    
        return $this;
    }

    /**
     * Remove orders
     *
     * @param Shop\OrderBundle\Entity\Order $orders
     */
    public function removeOrder(\Shop\OrderBundle\Entity\Order2 $orders)
    {
        $this->orders->removeElement($orders);
    }

    /**
     * Get orders
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getOrders()
    {
        return $this->orders;
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
     * @ORM\PreRemove
     */
    public function preRemove()
    {       
        $questions = $this->getQuestions();
        foreach($questions as $question){
            $question->setUser(NULL);
        }
    }
    
    
    public function getReviewerLangages()
    {
        $roles = $this->getRoles();
        $pattern = '#^ROLE_REVIEWER_#';
        $languages = array();
        
        foreach($roles as $role){
            if(preg_match($pattern, $role)){
                $language = explode('_', $role);
                array_push($languages, end($language));
            }
        }
        
        return $languages;
    }
    
}