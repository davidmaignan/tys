<?php

namespace Security\RegistrationBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class UserConfirmationEvent extends Event
{
    
    protected $email;

    public function __construct($email){
        $this->email = $email;
    }
    
    public function getEmail()
    {
        return $this->email;
    }
    
    
}