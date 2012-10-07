<?php

namespace Mailer\MailBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class EmailEvent extends Event
{
    
    protected $message;
    protected $status;
    protected $activationKey;


    public function __construct(\Swift_Message $message, $status, $activationKey)
    {
        $this->message          = $message;
        $this->status           = $status;
        $this->activationKey    = $activationKey;
    }
    
    public function getMessage()
    {
        return $this->message;
    }
    
    public function getStatus()
    {
        return $this->status;
    }
    
    public function getActivationKey()
    {
        return $this->activationKey;
    }
    
}
