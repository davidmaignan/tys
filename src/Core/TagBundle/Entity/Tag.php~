<?php

namespace Core\TagBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Core\QuestionBundle\Entity\Question;
use Exam\CoreBundle\Entity\ExamCriteria;

/**
 * Core\TagBundle\Entity\Tag
 *
 * @ORM\Table(name="tag")
 * @ORM\Entity(repositoryClass="Core\TagBundle\Entity\TagRepository")
 */
class Tag {

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
     * @ORM\ManyToMany(targetEntity="Core\QuestionBundle\Entity\Question", mappedBy="tags")
     */
    private $questions;
    
    /**
     * @ORM\ManyToMany(targetEntity="Exam\CoreBundle\Entity\ExamCriteria", mappedBy="tags")
     */
    private $examCriterias;
    

    public function __construct() {
        $this->questions = new ArrayCollection();
        $this->examCriterias = new ArrayCollection();
    }
    
    public function __toString()
    {
        return $this->name;
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
     * @return Tag
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
     * @return Tag
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
     * Add questions
     *
     * @param Core\QuestionBundle\Entity\Question $questions
     * @return Tag
     */
    public function addExamCriteria(ExamCriteria $examCriteria)
    {
        $this->examCriterias[] = $examCriteria;
        return $this;
    }

    /**
     * Remove questions
     *
     * @param $questions
     */
    public function removeExamCriteria(ExamCriteria $examCriteria)
    {
        $this->examCriterias->removeElement($examCriteria);
    }

    /**
     * Get questions
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getExamCriterias()
    {
        return $this->examCriterias;
    }
}