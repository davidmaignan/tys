<?php

namespace Dm\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $mailer = $this->get('my_mailer');
        return $this->render('DmSiteBundle:Default:index.html.twig', array('mailer'=>$mailer));
    }
}
