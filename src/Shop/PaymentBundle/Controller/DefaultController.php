<?php

namespace Shop\PaymentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ShopPaymentBundle:Default:index.html.twig');
    }
}
