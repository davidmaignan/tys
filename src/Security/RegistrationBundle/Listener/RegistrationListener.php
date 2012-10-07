<?php

namespace Security\RegistrationBundle\Listener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Security\RegistrationBundle\Event\UserConfirmationEvent;

use Doctrine\Common\Persistence\ObjectManager;

class RegistrationListener
{
    
    protected $message;
    protected $container;
    
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    
    public function onConfirmed(UserConfirmationEvent $event)
    {
        
        $email    = $event->getEmail();
        var_dump($email->getRecipient());
        //exit;
        
        $em = $this->container->get('doctrine')->getEntityManager();
        
        
    }
    
}
