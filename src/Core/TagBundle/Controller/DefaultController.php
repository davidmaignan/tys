<?php

namespace Core\TagBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('CoreTagBundle:Default:index.html.twig', array('name' => $name));
    }
}
