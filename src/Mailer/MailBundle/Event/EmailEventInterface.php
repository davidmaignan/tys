<?php

namespace Mailer\MailBundle\Event;

/**
 * Interface for Email Event Object 
 */
interface EmailEventInterface {
    
    public function getMessage();
    
    public function getStatus();
       
}
