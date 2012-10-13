<?php

namespace Library\TwitterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('LibraryTwitterBundle:Default:index.html.twig', array('name' => $name));
    }
}
