<?php

namespace Mailer\MailBundle\Mailer;


interface MailerInterface {
    
    public function sendEmailMessage(\Swift_Message $message);
    
}