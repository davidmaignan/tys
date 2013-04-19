<?php
/*
 * This file is part of the CoreAnswerBundle package.
 *
 * 2013 (c) Testyrskills.com <http://www.testyrskills.com/>
 *
 */

namespace Core\SectionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Exam\CoreBundle\Entity\ExamCriteriaInterface;
use Core\QuestionBundle\Entity\QuestionInterface;


/**
 * @author David Maignan <davidmaignan@gmail.com>
 */

/**
 * Core\SectionBundle\Entity\Section
 *
 * @ORM\Table(name="section")
 * @ORM\Entity(repositoryClass="Core\SectionBundle\Entity\SectionRepository")
 */
class Section implements SectionInterface
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
     * @param Core\QuestionBundle\Entity\Question $question
     * @return Section
     */
    public function addQuestion(\Core\QuestionBundle\Entity\Question $question)
    {
        $this->questions[] = $question;
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
     * @param Exam\CoreBundle\Entity\ExamCriteriaInterface $examCriteria
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
     * @param Exam\CoreBundle\Entity\ExamCriteriaInterface $examCriteria
     */
    public function removeExamCriteria(ExamCriteriaInterface $examCriteria)
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
