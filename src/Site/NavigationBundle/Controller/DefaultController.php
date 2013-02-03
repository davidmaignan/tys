<?php

namespace Site\NavigationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('SiteNavigationBundle:Default:index.html.twig', array('name' => $name));
    }
}
