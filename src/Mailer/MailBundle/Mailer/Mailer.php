<?php

namespace Mailer\MailBundle\Mailer;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Mailer\MailBundle\Event\EmailRegistrationEvent;
use Mailer\MailBundle\Event\EmailResettingEvent;
use Mailer\MailBundle\Event\EmailQuestionSubmissionEvent;

use Core\QuestionBundle\Entity\QuestionInterface;
use FOS\UserBundle\Model\UserInterface;
use Mailer\MailBundle\Mailer\MailerInterface;

/**
 * Mailer service 
 */
class Mailer implements MailerInterface
{ 
    protected $container;
    
    protected $message;
    
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    
    
    /**
     * Send Email registration
     * @param UserInterface $user 
     */
    public function sendRegistrationMessage(UserInterface $user)
    {
        
        $to = $user->getEmail();
        $from = ('registration@testyrskills.com');
        $subject = 'Registration confirmation';
        
        //Generate link in email
        $activationKey = $this->generateActivationKey();
        
        $link = $this->container->get('router')->generate('security_registration_verify', array(
            'email'=> $to,
            'activationKey' =>$activationKey
        ), true);

        $body = $this->container->get('templating')->renderResponse(
                    'SecurityRegistrationBundle:Registration:registration.txt.twig', array(
                        'user' => $user,
                        'link' => $link,
                ));
        
        $message = $this->createMessage($to, $from, $subject, $body);
        $status = $this->sendEmailMessage($message);
        
        //Dispatch Event
        $dispatcher = $this->container->get('event_dispatcher');
        $dispatcher->dispatch('email.message.save', new EmailRegistrationEvent($message, $status, $activationKey));

    }
    
    /**
     * Send Email resetting password
     * @param UserInterface $user 
     */
    public function sendResettingEmailMessage(UserInterface $user)
    {
        $to = $user->getEmail();
        $from = 'subscribe@testyourskills.com';
        $subject = 'Resetting password';
        

        $url = $this->container->get('router')->generate('fos_user_resetting_reset', array('token' => $user->getConfirmationToken()), true);
        $body = $this->container->get('templating')->render('SecurityAuthenticateBundle:Resetting:email.txt.twig',
                array(
                    'user'              => $user,
                    'confirmationUrl'   => $url
        ));
        
        $message = $this->createMessage($to, $from, $subject, $body);
        
        $status = $this->sendEmailMessage($message);
        
        $dispatcher = $this->container->get('event_dispatcher');
        
        $dispatcher->dispatch('email.message.save', new EmailResettingEvent($message, $status));
    }
    
    /**
     * Send Email message
     * @param Swift_Message $message
     * @return boolean 
     */
    public function sendEmailMessage(\Swift_Message $message)
    {
        return $this->container->get('mailer')->send($message);
    }


    /**
     * Generate an ActivationKey - to be place in more appropriate object: User ??
     * @return integer 
     */
    private function generateActivationKey()
    {
        return  mt_rand() . mt_rand() . mt_rand() . mt_rand() . mt_rand();
    }
    
    /**
     * Send email for question submitted
     * @param QuestionInterface $question
     * @param UserInterface $user 
     */
    public function sendQuestionEmailSubmission(QuestionInterface $question, UserInterface $user)
    {
        
        $to = $user->getEmail();
        $from = ('questions@testyrskills.com');
        $subject = 'Question submitted';
        
        $url = 'to define';
        $body = $this->container->get('templating')->render('QuestionCreateBundle:Create:questionSubmitted.txt.twig',
                array(
                    'user'              =>  $user,
                    'question'          =>  $question,
                    'confirmationUrl'   =>  $url
        ));
        
        $message = $this->createMessage($to, $from, $subject, $body);
        
        $status = $this->sendEmailMessage($message);
        
        $dispatcher = $this->container->get('event_dispatcher');
        $dispatcher->dispatch('email.message.save', new EmailQuestionSubmissionEvent($message, $status, $question));
        

        //Send email to correcteur
        $to = 'proofreader@testyrskills.com';
        $from = 'questions@testyrskills.com';
        $subject = 'Question submitted';
        
        $url = 'to define';
        $body = $this->container->get('templating')->render('QuestionCreateBundle:Create:questionPending.txt.twig',
                array(
                    'question'          =>  $question,
                    'confirmationUrl'   =>  $url
        ));
        
        $message = $this->createMessage($to, $from, $subject, $body);
        $status = $this->sendEmailMessage($message);
        $dispatcher = $this->container->get('event_dispatcher');
        $dispatcher->dispatch('email.message.save', new EmailQuestionSubmissionEvent($message, $status, $question));

    }
    
    /**
     * Create message to be send
     * @param email $to
     * @param email $from
     * @param string $subject
     * @param string $body
     * @return \Swift_Message 
     */
    public function createMessage($to, $from, $subject, $body)
    {
        $message = \Swift_Message::newInstance()
                    ->setSubject($subject)
                    ->setFrom($from)
                    ->setTo($to)
                    ->setBody($body);
        
        return $message;
    }
    
    /**
     * Check if use - delete otherwise
     * @param UserInterface $user 
     */
    public function sendConfirmationEmailMessage(UserInterface $user) {
        
    }
    
}
