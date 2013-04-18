<?php

/*
 * This file is part of the CoreLevelBundle package.
 *
 * 2013 (c) Testyrskills.com <http://www.testyrskills.com/>
 *
 */
namespace Core\LevelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Core\QuestionBundle\Entity\QuestionInterface;

/**
 * @author David Maignan <davidmaignan@gmail.com>
 */

/**
 * Core\LevelBundle\Entity\Level
 *
 * @ORM\Table(name="level")
 * @UniqueEntity({"name"})
 * @ORM\Entity(repositoryClass="Core\LevelBundle\Entity\LevelRepository")
 */
class Level implements LevelInterface {

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
     * @ORM\Column(name="name", type="string", length=255, unique = true)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Core\QuestionBundle\Entity\Question", mappedBy="level")
     */
    protected $questions;
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->questions = new ArrayCollection();
    }
    
    /**
     * toString
     * 
     * @return string
     */
    public function __toString() {
        return $this->getName();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Level
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName() {
        return $this->name;
    }
    
    /**
     * Add questions
     *
     * @param Core\QuestionBundle\Entity\Question $questions
     * @return Level
     */
    public function addQuestion(QuestionInterface $question)
    {
        $this->questions[] = $question;
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
}
