<?php

namespace Exam\PracticeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class InvitationController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ExamPracticeBundle:Default:index.html.twig', array('name' => $name));
    }
}
