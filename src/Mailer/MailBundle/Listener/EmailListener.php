<?php

namespace Mailer\MailBundle\Listener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Mailer\MailBundle\Event\EmailEvent;
use Mailer\EmailBundle\Entity\RegistrationEmail;

use Doctrine\Common\Persistence\ObjectManager;

use Mailer\MailBundle\Event\EmailEventInterface;
use Mailer\MailBundle\Event\EmailRegistrationEvent;
use Mailer\MailBundle\Event\EmailResettingEvent;
use Mailer\MailBundle\Event\EmailQuestionSubmissionEvent;
use Mailer\MailBundle\Event\EmailQuestionReviewEvent;
use Mailer\MailBundle\Event\EmailQuestionFeedbackEvent;
use Mailer\MailBundle\Event\EmailQuestionApprovedEvent;
use Mailer\MailBundle\Event\EmailSendInvitationEvent;

class EmailListener
{
    
    protected $message;
    protected $container;
    protected $emailManager;
    
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    
    public function onSave(EmailEventInterface $event)
    {   
        
        //Switch loop to get doctrine service (rewrite to a factory pattern)
        switch(true){
            
            case($event instanceof EmailRegistrationEvent):
                $this->emailManager = $this->container->get('email_registration_doctrine');
                break;
            
            case($event instanceof EmailResettingEvent):
                $this->emailManager = $this->container->get('email_resetting_doctrine');
                break;
            
            case($event instanceof EmailQuestionSubmissionEvent):
                $this->emailManager = $this->container->get('email_question_submission_doctrine');
                break;
            
            case($event instanceof EmailQuestionReviewEvent):
                $this->emailManager = $this->container->get('email_question_review_doctrine');
                break;
            
            case($event instanceof EmailQuestionFeedbackEvent):
                $this->emailManager = $this->container->get('email_question_feedback_doctrine');
                break;
            
            case($event instanceof EmailQuestionApprovedEvent):
                $this->emailManager = $this->container->get('email_question_approved_doctrine');
                break;
            
            case($event instanceof EmailSendInvitationEvent):
                $this->emailManager = $this->container->get('email_send_invitation_doctrine');
                break;
            
            default:
                throw new \Exception('No email event recognized!');
                break; 
        }
        
        $email = $this->emailManager->createEmail();
        
        $this->emailManager->bind($email, $event);
        $this->emailManager->updateEmail($email);
    }
}
