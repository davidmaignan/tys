<?php

namespace Api\OauthBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ApiOauthBundle:Default:index.html.twig', array('name' => $name));
    }
}
