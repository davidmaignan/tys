<?php

namespace Library\JQueryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('LibraryJQueryBundle:Default:index.html.twig', array('name' => $name));
    }
}
