<?php


/*
 * This file is part of the MailerEmailBundle package.
 *
 * (c) Testyrskills.com <http://www.Testyrskills.com/>
 *
 */

namespace Mailer\EmailBundle\Model;

use Mailer\MailBundle\Event\EmailEventInterface;
use Mailer\EmailBundle\Entity\EmailInterface;

/**
 * Abstract EmailManager Manager implementation used as base class for email concrete manager.
 *
 * @author David Maignan <davidmaignan@gmail.com>
 */
abstract class EmailManager implements EmailManagerInterface
{
    /**
     * Constructor.
     *
     */
    public function __construct()
    {
        
    }
    
    /**
     * Returns an empty question instance
     *
     * @return EmailInterface
     */
    public function createEmail()
    {
        $class = $this->getClass();
        $email = new $class;
        
        return $email;
    }
    

    /**
     * {@inheritDoc}
     */
    public function supportsClass($class)
    {
        return $class === $this->getClass();
    }
    
    /**
     * Bind parameters from the event to email object
     * @param EmailInterface $email
     * @param EmailEventInterface $event 
     */
    protected function bind(EmailInterface $email, EmailEventInterface $event)
    {
        
        
        
        $message    = $event->getMessage();
        $status     = $event->getStatus();
        
        $email->setRecipient(key($message->getTo()));
        $email->setSubject($message->getSubject());
        $email->setBody($message->getBody());
        $email->setStatus($status);
    }
}
