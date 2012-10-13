<?php

namespace Security\RegistrationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ConfirmationController extends Controller
{
    
    /**
     * Controller to confirme registration with email sent
     * @param type $email
     * @param type $activationKey 
     * 
     * @return redirect
     */
    public function indexAction($email, $activationKey)
    {
        $em = $this->getDoctrine()->getRepository('MailerEmailBundle:Email')->checkActivation($email, $activationKey, $this->get('event_dispatcher'));
        $url = $this->generateUrl('security_registration_activated');

        return $this->redirect($this->generateUrl('security_registration_activated'));
    }
    
    public function confirmedAction(){
        
        return $this->render('SecurityRegistrationBundle:Confirmation:confirmed.html.twig');
        
    }
    
}
