<?php

namespace Exam\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Core\QuestionBundle\Entity\Question;


/**
 * Exam\CoreBundle\Entity\ExamQuestion
 *
 * @ORM\Table(name="criteria_question")
 * @ORM\Entity(repositoryClass="Exam\CoreBundle\Entity\CriteriaQuestion")
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
     * @ORM\OneToOne(targetEntity="ExamCriteria", inversedBy="examQuestion")
     * @ORM\JoinColumn(name="examCriteria_id", referencedColumnName="id")
     */
    private $examCriteria;
    
    
    /**
     * @ORM\ManyToMany(targetEntity="Core\QuestionBundle\Entity\Question", inversedBy="criteriaQuestions")
     * @ORM\JoinTable(name="exam_question_questions")
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
     * Add questions
     *
     * @param \Core\QuestionBundle\Entity\Question $questions
     * @return ExamQuestion
     */
    public function addQuestion(\Core\QuestionBundle\Entity\Question $questions)
    {
        $this->questions[] = $questions;

        return $this;
    }

    /**
     * Remove questions
     *
     * @param \Core\QuestionBundle\Entity\Question $questions
     */
    public function removeQuestion(\Core\QuestionBundle\Entity\Question $questions)
    {
        $this->questions->removeElement($questions);
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
