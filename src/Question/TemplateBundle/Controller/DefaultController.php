<?php

namespace Question\TemplateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('QuestionTemplateBundle:Default:index.html.twig', array('name' => $name));
    }
}
