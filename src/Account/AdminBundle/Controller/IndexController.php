<?php

namespace Account\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexController extends Controller
{
    public function indexAction()
    {
        return $this->render('AccountAdminBundle:Index:index.html.twig');
    }
}
