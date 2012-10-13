<?php

namespace Question\CreateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('QuestionCreateBundle:Default:index.html.twig', array('name' => $name));
    }
}
