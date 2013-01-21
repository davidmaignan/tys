<?php

namespace Exam\ManageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ShowController extends Controller
{
    public function indexAction($id)
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $exam = $this->get('exam_generate.exam_manager.doctrine')->findExamBy(array('id'=>$id, 'owner'=>$user));
        
        if(!$exam){
            return $this->createNotFoundException('No exam was found!');
        }
        
        return $this->render('ExamManageBundle:Show:index.html.twig', array('exam'=>$exam));
    }
}
