<?php

namespace Exam\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Exam\CoreBundle\Entity\ExamAnser
 *
 * @ORM\Table(name="exam_anser")
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
     * @ORM\OneToOne(targetEntity="Exam\CoreBundle\Entity\Exam", mappedBy="exam", cascade={"persist"} )
     * @Assert\NotBlank()
     */
    private $exam;

    /**
     * @ORM\OneToOne(targetEntity="Security\AuthenticateBundle\Entity\User", mappedBy="user", cascade={"persist"} )
     * @Assert\NotBlank()
     */
    private $user;
    
    /**
     * @ORM\OneToOne(targetEntity="Core\QuestionBundle\Entity\Question", mappedBy="question", cascade={"persist"} )
     * @Assert\NotBlank()
     */
    private $question;
    
    
    /**
     * @ORM\OneToOne(targetEntity="Core\AnswerBundle\Entity\Answer", mappedBy="answer", cascade={"persist"} )
     * @Assert\NotBlank()
     */
    private $answer;
    
    /**
     * @var text $title
     *
     * @ORM\Column(name="title", type="text")
     * 
     * @Assert\NotBlank(groups={"Default"})
     * 
     */
    private $title;

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
     * Set exam
     *
     * @param \Exam\CoreBundle\Entity\Exam $exam
     * @return ExamAnswer
     */
    public function setExam(\Exam\CoreBundle\Entity\Exam $exam = null)
    {
        $this->exam = $exam;

        return $this;
    }

    /**
     * Get exam
     *
     * @return \Exam\CoreBundle\Entity\Exam 
     */
    public function getExam()
    {
        return $this->exam;
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
     * @param \Core\QuestionBundle\Entity\Question $question
     * @return ExamAnswer
     */
    public function setQuestion(\Core\QuestionBundle\Entity\Question $question = null)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return \Core\QuestionBundle\Entity\Question 
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set answer
     *
     * @param \Core\QuestionBundle\Entity\Question $answer
     * @return ExamAnswer
     */
    public function setAnswer(\Core\QuestionBundle\Entity\Question $answer = null)
    {
        $this->answer = $answer;

        return $this;
    }

    /**
     * Get answer
     *
     * @return \Core\QuestionBundle\Entity\Question 
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return ExamAnswer
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }
}
