<?php

namespace Mailer\MailBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class EmailRegistrationEvent extends Event implements EmailEventInterface
{
    
    protected $message;
    protected $status;
    protected $activationKey;

    /**
     * @param \Swift_Message $message
     * @param type $status
     * @param type $activationKey 
     */
    public function __construct(\Swift_Message $message, $status, $activationKey = null)
    {
        $this->message          = $message;
        $this->status           = $status;
        $this->activationKey    = $activationKey;
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
     * Get activation key
     * @return int 
     */
    public function getActivationKey()
    {
        return $this->activationKey;
    }
    
}
