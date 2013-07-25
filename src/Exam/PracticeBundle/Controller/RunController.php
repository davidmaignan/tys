<?php
/*
 * This file is part of the ExamPracticeBundle package.
 *
 * 2013 (c) Testyrskills.com <http://www.Testyrskills.com/>
 *
 */
namespace Exam\PracticeBundle\Controller;

/**
 * Exam practice run controller
 *
 * @author davidmaignan
 */


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RunController extends Controller
{
    /**
     * 
     */
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
        
        //Retrieve criteria question
        $criteriaQuestionId = $session->get('criteriaQuestion');
        
        $em               = $this->getDoctrine()->getManager();
        $criteriaQuestion = $em->getRepository('ExamCoreBundle:CriteriaQuestion')->findOneBy(array('id'=>$criteriaQuestionId)); 
        
        //Retrieve question        
        $questionId      = $session->get('question');
        $questionManager = $this->get('question_create.question_manager.doctrine');
        $question        = $questionManager->findQuestionBy($questionId);
        
        //Update question counter
        $counter = $session->get('questionCounter');
        $session->set('questionCounter', ++$counter);
        
        return $this->render('ExamPracticeBundle:Run:index.html.twig', 
                array('criteriaQuestion' => $criteriaQuestion, 
                      'form' => $form->createView(), 
                      'question'=> $question
                ));
    }
}
