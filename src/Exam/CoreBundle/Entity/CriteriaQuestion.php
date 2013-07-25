<?php

/**
 * This file is part of the ExamCoreBundle package.
 *
 * (c) Testyrskills.com <http://www.Testyrskills.com/>
 *
 */

namespace Exam\CoreBundle\Entity;

/**
 * @author David Maignan <davidmaignan@gmail.com>
 */

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Core\QuestionBundle\Entity\Question;


/**
 * Exam\CoreBundle\Entity\CriteriaQuestion
 *
 * @ORM\Table(name="criteria_question")
 * @ORM\Entity(repositoryClass="Exam\CoreBundle\Entity\CriteriaQuestionRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class CriteriaQuestion implements CriteriaQuestionInterface
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**  The owning side has 'inversedBy'. Its table will have
     *   the foreign key.
     * @ORM\ManyToOne(targetEntity="Exam\CoreBundle\Entity\ExamCriteria", inversedBy="criteriaQuestions")
     * @ORM\JoinColumn(name="examCriteria_id", referencedColumnName="id")
     */
    private $examCriteria;
    
    /**
     * @ORM\ManyToMany(targetEntity="Core\QuestionBundle\Entity\Question", inversedBy="criteriaQuestions")
     * @ORM\JoinTable(name="criteria_question_questions")
     */
    private $questions;
    
     /**
     * Constructor
     */
    public function __construct()
    {
        $this->questions = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set examCriteria
     *
     * @param \Exam\CoreBundle\Entity\ExamCriteria $examCriteria
     * @return ExamQuestion
     */
    public function setExamCriteria(\Exam\CoreBundle\Entity\ExamCriteria $examCriteria = null)
    {
        $this->examCriteria = $examCriteria;

        return $this;
    }

    /**
     * Get examCriteria
     *
     * @return \Exam\CoreBundle\Entity\ExamCriteria 
     */
    public function getExamCriteria()
    {
        return $this->examCriteria;
    }

    /**
     * Add question
     *
     * @param \Core\QuestionBundle\Entity\QuestionInterface $question
     * @return ExamQuestion
     */
    public function addQuestion(\Core\QuestionBundle\Entity\QuestionInterface $question)
    {
        $this->questions[] = $question;

        return $this;
    }

    /**
     * Remove question
     *
     * @param \Core\QuestionBundle\Entity\QuestionInterface $question
     */
    public function removeQuestion(\Core\QuestionBundle\Entity\QuestionInterface $question)
    {
        $this->questions->removeElement($question);
    }

    /**
     * Get questions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getQuestions()
    {
        return $this->questions;
    }
}
