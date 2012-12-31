<?php

namespace Dm\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Core\QuestionBundle\Entity\QuestionStatus;
use Core\QuestionBundle\Entity\Question;

class DefaultController extends Controller
{
    /**
     * Homepage
     * @return type 
     */
    public function indexAction()
    {    
        return $this->render('DmSiteBundle:Default:index.html.twig');
    }
}
