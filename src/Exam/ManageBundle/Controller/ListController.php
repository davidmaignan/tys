<?php

namespace Exam\ManageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ListController extends Controller
{
    public function indexAction()
    {
        
        $exams = $this->get('exam_generate.exam_manager.doctrine')->findExams();
        
        //var_dump($exams);
        
        return $this->render('ExamManageBundle:List:index.html.twig', array('exams'=>$exams));
    }
}
