<?php

namespace Question\OwnerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ListController extends Controller
{
    public function indexAction()
    {
        return $this->render('QuestionOwnerBundle:List:index.html.twig');
    }
}
