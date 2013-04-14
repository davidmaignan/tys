<?php

namespace Exam\PracticeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class StartController extends Controller
{
    public function indexAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        
        //Retrieve examId
        $examManager = $this->get('exam_generate.exam_manager.doctrine');
        $exam = $examManager->findExamBy(array('id'=>1));
        //$examId = $em->getRepository('ExamCoreBundle:Exam')->findByUser($user);
                        
        //Retrieve first question
        $questions = $exam->getExamCriteria()->getExamQuestion()->getQuestions();
        $question = $questions[0];
        
        //Save Exam and first question ids in session
        $session = $this->getRequest()->getSession();
        $session->set('exam', array('id'=>$exam->getId()));
        
        $session->set('question', array('id'=> $question->getId()));
        
        return $this->render('ExamPracticeBundle:Start:index.html.twig');
    }
}
