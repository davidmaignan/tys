<?php

namespace Site\HomepageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PricingController extends Controller
{
    public function indexAction()
    {
        return $this->render('SiteHomepageBundle:Pricing:index.html.twig');
    }
}
