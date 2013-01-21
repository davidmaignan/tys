<?php

namespace Mailer\MailBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Exam\CoreBundle\Entity\ExamInterface;
use FOS\UserBundle\Model\UserInterface;

class EmailSendInvitationEvent extends Event implements EmailEventInterface
{
    
    protected $message;
    protected $status;
    protected $exam;
    protected $user;

    /**
     * @param \Swift_Message $message
     * @param int $status
     * @param QuestionInterface $question 
     */
    public function __construct(\Swift_Message $message, $status, ExamInterface $exam, UserInterface $user)
    {
        $this->message     = $message;
        $this->status      = $status;
        $this->exam        = $exam;
        $this->user        = $user;
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
     * Get exam
     * @return examInterface 
     */
    public function getExam()
    {
        return $this->exam;
    }
    
    /**
     * Get user
     * @return userInterface 
     */
    public function getUser()
    {
        return $this->user;
    }
    
}
