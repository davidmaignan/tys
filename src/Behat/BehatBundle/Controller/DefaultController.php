<?php

namespace Behat\BehatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('BehatBehatBundle:Default:index.html.twig', array('name' => $name));
    }
}
