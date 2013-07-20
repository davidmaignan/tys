<?php

namespace Exam\PracticeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class StartController extends Controller
{
    public function indexAction($examId)
    {       
        $user = $this->get('security.context')->getToken()->getUser();
        
        //Retrieve examId
        $examManager = $this->get('exam_generate.exam_manager.doctrine');
        $exam = $examManager->findExamBy(array('id'=>$examId));
                        
        //Retrieve first question
        $criteriaQuestions = $exam->getExamCriteria()->getCriteriaQuestions();    
        $criteriaQuestion = $criteriaQuestions->first();
        $questions = $criteriaQuestions->first()->getQuestions();
        
        //Save Exam and first question ids in session
        $session = $this->getRequest()->getSession();
        
        $session->set('criteriaQuestion', array('criteriaQuestionId'=>$criteriaQuestion->getId()));
        $session->set('question', array('id'=> $questions->first()->getId()));
        $session->set('questionCounter', 1);
        
        return $this->render('ExamPracticeBundle:Start:index.html.twig', array(
            'criteriaQuestion' => $criteriaQuestions
        ));
    }
}
