<?php

namespace Exam\ManageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ListController extends Controller
{
    public function indexAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $exams = $this->get('exam_generate.exam_manager.doctrine')->findExams($user);
        
        //var_dump($exams);
        //exit;
        
        return $this->render('ExamManageBundle:List:index.html.twig', array('exams'=>$exams));
    }
}
