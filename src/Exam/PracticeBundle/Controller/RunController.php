<?php

namespace Exam\PracticeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Exam\CoreBundle\Entity\ExamAnswer;
use Exam\PracticeBundle\Form\Type\ExamAnswerFormType;

class RunController extends Controller
{
    public function indexAction()
    {
        $form        = $this->container->get('question_create.contributor.form2');
        $formHandler = $this->container->get('question_create.contributor.form.handler2');
        
        $formHandler->process(false);
        
        //var_dump($formHandler);
        //exit;
        
        //var_dump($form);
        //exit;
        
        $session = $this->getRequest()->getSession();
        $request = $this->getRequest();
        
        $examId = $session->get('exam');
        
        $em = $this->getDoctrine()->getManager();
        $exam = $em->getRepository('ExamCoreBundle:Exam')->find($examId);
        
        $questions = $exam->getExamCriteria()->getExamQuestion()->getQuestions();
        $question = $questions[0];
        
        $examAnswer = new ExamAnswer();
        
        $examAnswer->setUser($this->get('security.context')->getToken()->getUser());
        $examAnswer->setExam($exam);
        $examAnswer->setQuestion($question);
        
        /*
        if('POST' === $request->getMethod()) {
            
            $form->bind($request);

            if ($form->isValid()) {
                // perform some action, such as saving the task to the database
                echo 'valid';
                
            }else{
                echo 'form invalid';
            }
        }
        */
        
        return $this->render('ExamPracticeBundle:Run:index.html.twig', 
                array('exam' => $exam, 'form' => $form->createView(), 'question'=> $question));
    }
}
