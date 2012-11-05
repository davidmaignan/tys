<?php

namespace Exam\GenerateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ExamGenerateBundle:Default:index.html.twig', array('name' => $name));
    }
}
