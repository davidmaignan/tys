<?php

namespace Core\CommentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\MinLength;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Core\QuestionBundle\Entity\Question;
use Security\AuthenticateBundle\Entity\User;

/**
 * @ORM\Entity 
 * @ORM\Table(name="comment")
 * @ORM\Entity(repositoryClass="Core\CommentBundle\Entity\CommentRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Comment implements CommentInterface
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @var text $body
     * 
     * @ORM\Column(name="body", type="text") 
     * @Assert\NotBlank()
     */
    private $body;
    
            
    /**
    * @ORM\ManyToOne(targetEntity="Core\QuestionBundle\Entity\Question", inversedBy="comments")
    * @ORM\JoinColumn(name="question_id", referencedColumnName="id",
                onDelete="CASCADE")
    */
    private $question;
    
    
    /**
     * @ORM\ManyToOne(targetEntity="Security\AuthenticateBundle\Entity\User", inversedBy="comments")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $user;
    
    
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
    
    
    public function __construct() {
        
        $this->setCreatedAt(new \DateTime());
        $this->setUpdatedAt(new \DateTime());
    }
    
    /**
     * @ORM\preUpdate
     */
    public function setUpdatedAtValue()
    {
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
     * Set body
     *
     * @param string $body
     * @return Comment
     */
    public function setBody($body)
    {
        $this->body = $body;
    
        return $this;
    }

    /**
     * Get body
     *
     * @return string 
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Comment
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
     * @return Comment
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
     * Set question
     *
     * @param Core\QuestionBundle\Entity\Question $question
     * @return Comment
     */
    public function setQuestion(\Core\QuestionBundle\Entity\Question $question = null)
    {
        $this->question = $question;
    
        return $this;
    }

    /**
     * Get question
     *
     * @return Core\QuestionBundle\Entity\Question 
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set user
     *
     * @param Security\AuthenticateBundle\Entity\User $user
     * @return Comment
     */
    public function setUser(\Security\AuthenticateBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return Security\AuthenticateBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

}
