<?php

namespace Library\RequireBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('LibraryRequireBundle:Default:index.html.twig', array('name' => $name));
    }
}
