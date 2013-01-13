<?php

namespace Site\HomepageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SiteHomepageBundle:Default:index.html.twig');
    }
}
