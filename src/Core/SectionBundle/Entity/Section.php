<?php

namespace Core\SectionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Exam\CoreBundle\Entity\ExamCriteria;

/**
 * Core\SectionBundle\Entity\Section
 *
 * @ORM\Table(name="section")
 * @ORM\Entity(repositoryClass="Core\SectionBundle\Entity\SectionRepository")
 */
class Section
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
     * @ORM\OneToMany(targetEntity="Core\QuestionBundle\Entity\Question", mappedBy="section")
     */
    protected $questions;
    
    /**
     * @ORM\ManyToMany(targetEntity="Exam\CoreBundle\Entity\ExamCriteria", mappedBy="sections")
     */
    private $examCriterias;

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
     * @return Section
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
        $this->examCriterias = new ArrayCollection();
    }
    
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Set questions
     *
     * @param string $questions
     * @return Section
     */
    public function setQuestions($questions)
    {
        $this->questions = $questions;
        
        return $this;
    }

    /**
     * Get questions
     *
     * @return string 
     */
    public function getQuestions()
    {
        return $this->questions;
    }

    /**
     * Add questions
     *
     * @param Dm\QuestionBundle\Entity\Question $questions
     * @return Section
     */
    public function addQuestion(\Core\QuestionBundle\Entity\Question $questions)
    {
        $this->questions[] = $questions;
        return $this;
    }

    /**
     * Remove questions
     *
     * @param $questions
     */
    public function removeQuestion(\Core\QuestionBundle\Entity\Question $questions)
    {
        $this->questions->removeElement($questions);
    }
    
    /**
     * Add examCriterias
     *
     * @param Exam\CoreBundle\Entity\ExamCriteria $examCriteria
     * @return Section
     */
    public function addExamCriteria(ExamCriteria $examCriteria)
    {
        $this->examCriterias[] = $examCriteria;
        return $this;
    }

    /**
     * Remove examCriterias
     *
     * @param $examCriteria
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
