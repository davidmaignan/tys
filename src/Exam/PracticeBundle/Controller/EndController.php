<?php

namespace Exam\PracticeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EndController extends Controller
{
    public function indexAction()
    {
        return $this->render('ExamPracticeBundle:End:index.html.twig');
    }
}
