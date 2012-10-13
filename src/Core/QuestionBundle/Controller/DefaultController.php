<?php

namespace Core\QuestionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('CoreQuestionBundle:Default:index.html.twig');
    }
}
