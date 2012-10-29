<?php

namespace Shop\OrderBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ShopOrderBundle:Default:index.html.twig', array('name' => $name));
    }
}
