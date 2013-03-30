<?php

namespace Exam\PracticeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RunController extends Controller
{
    public function indexAction()
    {
        $session = $this->getRequest()->getSession();
        
        $examId = $session->get('exam');
        
        $em = $this->getDoctrine()->getManager();
        $exam = $em->getRepository('ExamCoreBundle:Exam')->find($examId);
        
        return $this->render('ExamPracticeBundle:Run:index.html.twig', array('exam' => $exam));
    }
}
