<?php

namespace Mailer\MailBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Core\QuestionBundle\Entity\QuestionInterface;

class EmailQuestionApprovedEvent extends Event implements EmailEventInterface
{
    
    protected $message;
    protected $status;
    protected $question;

    /**
     * @param \Swift_Message $message
     * @param int $status
     * @param QuestionInterface $question 
     */
    public function __construct(\Swift_Message $message, $status, QuestionInterface $question)
    {
        $this->message     = $message;
        $this->status      = $status;
        $this->question    = $question;
    }
    
    /**
     * Get message
     * @return \Swift_Message 
     */
    public function getMessage()
    {
        return $this->message;
    }
    
    /**
     * Get status code
     * @return int 
     */
    public function getStatus()
    {
        return $this->status;
    }
    
    /**
     * Get question
     * @return int 
     */
    public function getQuestion()
    {
        return $this->question;
    }
    
}
