<?php

namespace Mailer\MailBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('MailerMailBundle:Default:index.html.twig', array('name' => $name));
    }
}
