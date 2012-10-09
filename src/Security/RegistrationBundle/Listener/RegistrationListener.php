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
        
        $email    = $event->getEmail()->getRecipient();
       
        $em = $this->container->get('doctrine')->getEntityManager();
        
        $user = $em->getRepository('SecurityAuthenticateBundle:User')->findOneBy(array('email'=>$email));
        
        if($user){
            $user->setConfirmed(true);
            $em->persist($user);
            $em->flush();
            return true;
        }
        
        return false;
        
        
    }
    
}
