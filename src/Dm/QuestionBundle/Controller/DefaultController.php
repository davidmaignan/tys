<?php

namespace Dm\QuestionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('DmQuestionBundle:Default:index.html.twig', array('name' => $name));
    }
}
