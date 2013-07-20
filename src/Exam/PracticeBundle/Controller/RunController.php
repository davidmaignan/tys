<?php

namespace Exam\PracticeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Exam\CoreBundle\Entity\ExamAnswer;
use Exam\PracticeBundle\Form\Type\ExamAnswerFormType;

class RunController extends Controller
{
    public function indexAction()
    {
        $session = $this->getRequest()->getSession();
        $request = $this->getRequest();
        
        $form        = $this->container->get('question_create.contributor.form2');
        $formHandler = $this->container->get('question_create.contributor.form.handler2');
        
        $formHandler->process();
        
        if(null == $session->get('question')) {
            return $this->redirect($this->generateUrl('ExamPracticeBundle_Page_End_Index'));
        }
        
        //Retrieve Exam
        $criteriaQuestionId = $session->get('criteriaQuestion');
        
        $em               = $this->getDoctrine()->getManager();
        $criteriaQuestion = $em->getRepository('ExamCoreBundle:CriteriaQuestion')->find($criteriaQuestionId); 
        
        //Retrieve question        
        $questionId      = $session->get('question');
        $questionManager = $this->get('question_create.question_manager.doctrine');
        $question        = $questionManager->findQuestionBy($questionId);
        
        //Update question counter
        $counter = $session->get('questionCounter');
        $session->set('questionCounter', ++$counter);
        
        return $this->render('ExamPracticeBundle:Run:index.html.twig', 
                array('criteriaQuesiton' => $criteriaQuestion, 
                      'form' => $form->createView(), 
                      'question'=> $question
                ));
    }
}
