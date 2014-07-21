<?php

namespace Exam\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Exam\CoreBundle\Entity\ExamAnser
 *
 * @ORM\Table(name="criteria_question_answer")
 * @ORM\Entity(repositoryClass="Exam\CoreBundle\Entity\ExamAnswerRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class ExamAnswer implements ExamAnswerInterface
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
     * @ORM\ManyToOne(targetEntity="Exam\CoreBundle\Entity\CriteriaQuestion" )
     * @Assert\NotBlank()
     */
    private $criteriaQuestion;
    
    /**
     * @ORM\ManyToOne(targetEntity="Security\AuthenticateBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @Assert\NotBlank()
     */
    private $user;
    
    /**
     * @ORM\ManyToOne(targetEntity="Core\QuestionBundle\Entity\Question")
     * @ORM\JoinColumn(name="question_id", referencedColumnName="id")
     * @Assert\NotBlank()
     */
    private $question;
    
    /**
     * @ORM\ManyToOne(targetEntity="Core\AnswerBundle\Entity\Answer")
     * @ORM\JoinColumn(name="answer_id", referencedColumnName="id")
     * @Assert\NotBlank()
     */
    private $answer;

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
     * Set user
     *
     * @param \Security\AuthenticateBundle\Entity\User $user
     * @return ExamAnswer
     */
    public function setUser(\Security\AuthenticateBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Security\AuthenticateBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set question
     *
     * @param \Core\QuestionBundle\Entity\QuestionInterface $question
     * @return ExamAnswer
     */
    public function setQuestion(\Core\QuestionBundle\Entity\QuestionInterface $question = null)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return \Core\QuestionBundle\Entity\QuestionInterface 
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set answer
     *
     * @param \Core\AnswerBundle\Entity\AnswerInterface $answer
     * @return ExamAnswer
     */
    public function setAnswer(\Core\AnswerBundle\Entity\AnswerInterface $answer = null)
    {
        $this->answer = $answer;

        return $this;
    }

    /**
     * Get answer
     *
     * @return \Core\AnswerBundle\Entity\AnswerInterface
     */
    public function getAnswer()
    {
        return $this->answer;
    }


    /**
     * Set criteriaQuestion
     *
     * @param \Exam\CoreBundle\Entity\CriteriaQuestionInterface $criteriaQuestion
     * @return ExamAnswer
     */
    public function setCriteriaQuestion(\Exam\CoreBundle\Entity\CriteriaQuestionInterface $criteriaQuestion = null)
    {
        $this->criteriaQuestion = $criteriaQuestion;

        return $this;
    }

    /**
     * Get criteriaQuestion
     *
     * @return \Exam\CoreBundle\Entity\CriteriaQuestionInterface 
     */
    public function getCriteriaQuestion()
    {
        return $this->criteriaQuestion;
    }
}
