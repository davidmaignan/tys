<?php

namespace Core\SectionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('CoreSectionBundle:Default:index.html.twig', array('name' => $name));
    }
}
