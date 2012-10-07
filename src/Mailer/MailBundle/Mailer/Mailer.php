<?php

namespace Mailer\MailBundle\Mailer;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Mailer\MailBundle\Event\EmailEvent;

class Mailer
{
    
    protected $container;
    
    protected $message;
    
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    
    public function sendRegistrationMessage($user)
    {
        
        $email = $user->getEmail();
        $activationKey = $this->generateActivationKey();
        
        //var_dump($email);
        $body = $this->container->get('templating')->renderResponse(
                    'SecurityAuthenticateBundle:Registration:registration.txt.twig', array(
                        'user' => $user,
                        'activationKey' => $activationKey
                        )
                );
        
        $message = \Swift_Message::newInstance()
                        ->setSubject('Registration confirmation')
                        ->setFrom('subscribe@testyourskills.com')
                        ->setTo($email)
                        ->setBody($body);
        
        $status = $this->container->get('mailer')->send($message);
        
        //Dispatch Event
        $dispatcher = $this->container->get('event_dispatcher');
        $dispatcher->dispatch('email.message.save', new EmailEvent($message, $status, $activationKey));

        
    }
    
    /**
     * 
     * @return integer 
     */
    private function generateActivationKey()
    {
        return  mt_rand() . mt_rand() . mt_rand() . mt_rand() . mt_rand();
    }
    
    
}
