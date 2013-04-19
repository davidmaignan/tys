<?php

namespace Core\TagBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Core\QuestionBundle\Entity\QuestionInterface;
use Exam\CoreBundle\Entity\ExamCriteriaInterface;

/**
 * Core\TagBundle\Entity\Tag
 *
 * @ORM\Table(name="tag")
 * @ORM\Entity(repositoryClass="Core\TagBundle\Entity\TagRepository")
 */
class Tag implements TagInterface {

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
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->questions = new ArrayCollection();
        $this->examCriterias = new ArrayCollection();
    }
    /**
     * __toString
     * 
     * @return string
     */
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
     * Add question
     *
     * @param Core\QuestionBundle\Entity\QuestionInterface $question
     * @return Tag
     */
    public function addQuestion(QuestionInterface $question)
    {
        $this->questions[] = $question;
        return $this;
    }

    /**
     * Remove question
     *
     * @param Core\QuestionBundle\Entity\QuestionInterface $question
     */
    public function removeQuestion(QuestionInterface $question)
    {
        $this->questions->removeElement($question);
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
     * Add examCriteria
     *
     * @param \Exam\CoreBundle\Entity\ExamCriteriaInterface $examCriteria
     * @return Tag
     */
    public function addExamCriteria(ExamCriteriaInterface $examCriteria)
    {
        $this->examCriterias[] = $examCriteria;
        return $this;
    }

    /**
     * Remove examCriteria
     *
     * @param \Exam\CoreBundle\Entity\ExamCriteriaInterface $examCriteria
     */
    public function removeExamCriteria(ExamCriteria $examCriteria)
    {
        $this->examCriterias->removeElement($examCriteria);
    }

    /**
     * Get examCriterias
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getExamCriterias()
    {
        return $this->examCriterias;
    }
}
