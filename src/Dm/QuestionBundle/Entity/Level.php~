<?php

namespace Dm\QuestionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Dm\QuestionBundle\Entity\Question;

/**
 * Dm\QuestionBundle\Entity\Level
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Dm\QuestionBundle\Entity\LevelRepository")
 */
class Level {

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
     * @ORM\OneToMany(targetEntity="Question", mappedBy="Level")
     */
    protected $questions;

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

    public function __construct() {
        $this->questions = new ArrayCollection();
    }

    public function __toString() {
        return $this->getName();
    }


    /**
     * Add questions
     *
     * @param Dm\QuestionBundle\Entity\Question $questions
     * @return Level
     */
    public function addQuestion(\Dm\QuestionBundle\Entity\Question $questions)
    {
        $this->questions[] = $questions;
        return $this;
    }

    /**
     * Remove questions
     *
     * @param <variableType$questions
     */
    public function removeQuestion(\Dm\QuestionBundle\Entity\Question $questions)
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