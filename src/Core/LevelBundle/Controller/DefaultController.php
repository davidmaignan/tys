<?php

namespace Core\LevelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('CoreLevelBundle:Default:index.html.twig', array('name' => $name));
    }
}
