<?php

namespace Core\AnswerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('CoreAnswerBundle:Default:index.html.twig');
    }
}
