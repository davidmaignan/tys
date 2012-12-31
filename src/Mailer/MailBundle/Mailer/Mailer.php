<?php

namespace Mailer\MailBundle\Mailer;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Mailer\MailBundle\Event\EmailRegistrationEvent;
use Mailer\MailBundle\Event\EmailResettingEvent;
use Mailer\MailBundle\Event\EmailQuestionSubmissionEvent;
use Mailer\MailBundle\Event\EmailQuestionReviewEvent;
use Mailer\MailBundle\Event\EmailQuestionFeedbackEvent;
use Mailer\MailBundle\Event\EmailQuestionApprovedEvent;

use Core\QuestionBundle\Entity\QuestionInterface;
use FOS\UserBundle\Model\UserInterface;
use Mailer\MailBundle\Mailer\MailerInterface;

/**
 * Mailer service 
 */
class Mailer implements MailerInterface
{ 
    /**
     * @var Symfony\Component\DependencyInjection\Container 
     */
    protected $container;
    
    /**
     * @var Doctrine\ORM\EntityManager 
     */
    private $repo;
    
    /**
     * @var Symfony\Bundle\FrameworkBundle\Routing\Router;
     */
    private $router;
    
    
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
        

        $link = $this->container->get('router')->generate('fos_user_resetting_reset', array('token' => $user->getConfirmationToken()), true);
        $body = $this->container->get('templating')->render('SecurityAuthenticateBundle:Resetting:email.txt.twig',
                array(
                    'user'              => $user,
                    'confirmationUrl'   => $link
        ));
        
        $message = $this->createMessage($to, $from, $subject, $body);
        
        $status = $this->sendEmailMessage($message);
        
        $dispatcher = $this->container->get('event_dispatcher');
        
        $dispatcher->dispatch('email.message.save', new EmailResettingEvent($message, $status));
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
        
        $link = $this->container->get('router')->generate('question_owner_show', array('id' => $question->getId()), true);
        $body = $this->container->get('templating')->render('MailerMailBundle:Question:questionSubmitted.txt.twig',
                array(
                    'user'              =>  $user,
                    'question'          =>  $question,
                    'confirmationUrl'   =>  $link
        ));
        
        $message = $this->createMessage($to, $from, $subject, $body);
        
        $status = $this->sendEmailMessage($message);
        
        $dispatcher = $this->container->get('event_dispatcher');
        $dispatcher->dispatch('email.message.save', new EmailQuestionSubmissionEvent($message, $status, $question));
        
    }
    
    /**
     * Send email for review
     * @param QuestionInterface $question 
     */
    public function sendQuestionReviewEmail(QuestionInterface $question)
    {
        
        $user = $question->getUser();
        
        $to = 'reviewers@testyrskills.com';
        $from = 'questions@testyrskills.com';
        $subject = 'Question to review';
        
        $link = $this->container->get('router')->generate('question_review_show', array('id' => $question->getId()), true);
        $body = $this->container->get('templating')->render('MailerMailBundle:Question:questionReview.txt.twig',
                array(
                    'user'              =>  $user,
                    'question'          =>  $question,
                    'confirmationUrl'   =>  $link
        ));
        
        $message = $this->createMessage($to, $from, $subject, $body);
        
        $status = $this->sendEmailMessage($message);
        
        $dispatcher = $this->container->get('event_dispatcher');
        $dispatcher->dispatch('email.message.save', new EmailQuestionReviewEvent($message, $status, $question));

    }
    
    public function sendQuestionFeedbackEmail(QuestionInterface $question)
    {
        
        $user = $question->getUser();
        
        $to = $user->getEmail();;
        $from = 'questions@testyrskills.com';
        $subject = 'Question waiting for your feedback';
        
        $link = $this->container->get('router')->generate('question_feedback_show', array('id' => $question->getId()), true);
        //$link = 'to define';
        $body = $this->container->get('templating')->render('MailerMailBundle:Question:questionFeedback.txt.twig',
                array(
                    'user'              =>  $user,
                    'question'          =>  $question,
                    'confirmationUrl'   =>  $link
        ));
        
        $message = $this->createMessage($to, $from, $subject, $body);
        
        $status = $this->sendEmailMessage($message);
        
        $dispatcher = $this->container->get('event_dispatcher');
        $dispatcher->dispatch('email.message.save', new EmailQuestionFeedbackEvent($message, $status, $question));
        
    }
    
    public function sendQuestionApprovedEmail(QuestionInterface $question)
    {
        $user = $question->getUser();
        
        $to = $user->getEmail();;
        $from = 'questions@testyrskills.com';
        $subject = 'Your question has been approved';
        
        $link = $this->container->get('router')->generate('question_owner_list', array(), true);
        //$link = 'to define';
        $body = $this->container->get('templating')->render('MailerMailBundle:Question:questionApproved.txt.twig',
                array(
                    'user'              =>  $user,
                    'question'          =>  $question,
                    'confirmationUrl'   =>  $link
        ));
        
        $message = $this->createMessage($to, $from, $subject, $body);
        
        $status = $this->sendEmailMessage($message);
        
        $dispatcher = $this->container->get('event_dispatcher');
        $dispatcher->dispatch('email.message.save', new EmailQuestionApprovedEvent($message, $status, $question));

    }
    
    public function sendQuestionRejectedEmail(QuestionInterface $question)
    {
        echo 'sendQuestionRejectedEmail';
    }
    
    public function sendQuestionArchivedEmail(QuestionInterface $question)
    {
        echo 'sendQuestionArchivedEmail';
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
     * Check if use - delete otherwise
     * @param UserInterface $user 
     */
    public function sendConfirmationEmailMessage(UserInterface $user) {
        
    }
    
}
