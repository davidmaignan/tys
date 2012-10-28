<?php

namespace Mailer\MailBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class EmailResettingEvent extends Event implements EmailEventInterface
{
    
    protected $message;
    protected $status;
    
    /**
     * @param \Swift_Message $message
     * @param type $status 
     */
    public function __construct(\Swift_Message $message, $status)
    {
        $this->message          = $message;
        $this->status           = $status;
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
       
   
}
