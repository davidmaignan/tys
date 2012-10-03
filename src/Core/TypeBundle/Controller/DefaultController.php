<?php

namespace Core\TypeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('CoreTypeBundle:Default:index.html.twig', array('name' => $name));
    }
}
