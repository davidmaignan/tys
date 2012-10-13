<?php

namespace Mailer\MailBundle\Listener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Mailer\MailBundle\Event\EmailEvent;
use Mailer\EmailBundle\Entity\Email;

use Doctrine\Common\Persistence\ObjectManager;

class EmailListener
{
    
    protected $message;
    protected $container;
    
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    
    public function onSave(EmailEvent $event)
    {
        
        $message    = $event->getMessage();
        $activationKey = $event->getActivationKey();
        $status     = $event->getStatus();
        
        $em = $this->container->get('doctrine')->getEntityManager();
        
        $email = new Email();
        $email->setRecipient(key($message->getTo()));
        $email->setSubject($message->getSubject());
        $email->setBody($message->getBody());
        $email->setStatus($status);
        $email->setActivationkey($activationKey);
        
        $em->persist($email);
        $em->flush();
    }
    
}
