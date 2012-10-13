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
        
        $link = $this->container->get('router')->generate('security_registration_verify', array(
            'email'=> $email,
            'activationKey' =>$activationKey
        ), true);

        $body = $this->container->get('templating')->renderResponse(
                    'SecurityRegistrationBundle:Registration:registration.txt.twig', array(
                        'user' => $user,
                        'link' => $link,
                        )
                );
        
        $message = \Swift_Message::newInstance()
                        ->setSubject('Registration confirmation')
                        ->setFrom('subscribe@testyourskills.com')
                        ->setTo($email)
                        ->setBody($body);
        
        $status = $this->sendEmailMessage($message);
        
        //Dispatch Event
        $dispatcher = $this->container->get('event_dispatcher');
        $dispatcher->dispatch('email.message.save', new EmailEvent($message, $status, $activationKey));

    }
    
    public function sendResettingEmailMessage($user)
    {
        $email = $user->getEmail();
        

        $url = $this->container->get('router')->generate('fos_user_resetting_reset', array('token' => $user->getConfirmationToken()), true);
        $body = $this->container->get('templating')->render('SecurityAuthenticateBundle:Resetting:email.txt.twig',
                array(
            'user' => $user,
            'confirmationUrl' => $url
        ));
        
        $message = \Swift_Message::newInstance()
                        ->setSubject('Registration confirmation')
                        ->setFrom('subscribe@testyourskills.com')
                        ->setTo($email)
                        ->setBody($body);
        
        //var_dump($message);
        //exit;
        
        $status = $this->sendEmailMessage($message);
        
        $dispatcher = $this->container->get('event_dispatcher');
        $dispatcher->dispatch('email.message.save', new EmailEvent($message, $status));

        
    }
    
    protected function sendEmailMessage($message)
    {
        return $this->container->get('mailer')->send($message);
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
