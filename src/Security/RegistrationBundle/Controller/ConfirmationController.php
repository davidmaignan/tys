<?php

namespace Security\RegistrationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ConfirmationController extends Controller
{
    public function indexAction($email, $activationKey)
    {
        
        //var_dump($email, $activationKey);
        
        $em = $this->getDoctrine()->getRepository('MailerEmailBundle:Email')->checkActivation($email, $activationKey, $this->get('event_dispatcher'));
        
        return $this->render('SecurityRegistrationBundle:Confirmation:index.html.twig');
    }
}
