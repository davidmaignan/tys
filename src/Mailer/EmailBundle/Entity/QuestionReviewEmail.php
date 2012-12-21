<?php

namespace Mailer\EmailBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint as UniqueConstraint;
use Mailer\EmailBundle\Entity\Email;

use Core\QuestionBundle\Entity\Question;


/**
 * Mailer\EmailBundle\Entity\QuestionReviewEmail
 * @ORM\Entity
 * @ORM\Table(name="question_review")
 */
class QuestionReviewEmail extends Email implements EmailInterface
{
    
    /**
     * @ORM\OneToOne(targetEntity="Core\QuestionBundle\Entity\Question")
     * @ORM\JoinColumn(name="question_id", referencedColumnName="id")
     */
    private $question;
    
    

    /**
     * Set question
     *
     * @param Core\QuestionBundle\Entity\Question $question
     * @return QuestionSubmissionEmail
     */
    public function setQuestion(Question $question = null)
    {
        $this->question = $question;
    
        return $this;
    }

    /**
     * Get question
     *
     * @return Core\QuestionBundle\Entity\Question 
     */
    public function getQuestion()
    {
        return $this->question;
    }
}