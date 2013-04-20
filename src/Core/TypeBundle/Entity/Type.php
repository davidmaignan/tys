<?php

namespace Core\TypeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Core\QuestionBundle\Entity\QuestionInterface;

/**
 * Core\TypeBundle\Entity\Type
 *
 * @ORM\Table(name="type")
 * @ORM\Entity(repositoryClass="Core\TypeBundle\Entity\TypeRepository")
 */
class Type
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
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
    
    
    /**
     * @ORM\OneToMany(targetEntity="Core\QuestionBundle\Entity\Question", mappedBy="type")
     */
    protected $questions;

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
     * Set name
     *
     * @param string $name
     * @return Type
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }
    
    
    public function __construct()
    {
        $this->questions = new ArrayCollection();
    }
    
    /**
     * Add questions
     *
     * @param Core\QuestionBundle\Entity\QuestionInterface $questions
     * @return Type
     */
    public function addQuestion(QuestionInterface $questions)
    {
        $this->questions[] = $questions;
        return $this;
    }

    /**
     * Remove questions
     *
     * @param $questions
     */
    public function removeQuestion(QuestionInterface $questions)
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
    
    public function __toString()
    {
        return $this->name;
    }
}
