<?php

namespace Exam\PracticeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class StartController extends Controller
{
    public function indexAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        
        //Retreive exam
        $em = $this->getDoctrine()->getEntityManager();
        $exam = $em->getRepository('ExamCoreBundle:Exam')->findByUser($user);
                
        $session = $this->getRequest()->getSession();
        $session->set('exam', $exam);
        
        return $this->render('ExamPracticeBundle:Start:index.html.twig');
    }
}
