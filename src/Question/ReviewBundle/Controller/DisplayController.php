<?php

namespace Question\ReviewBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DisplayController extends Controller
{
    public function indexAction($id)
    {
        
        $em = $this->getDoctrine()->getEntityManager();
        
        $question = $em->getRepository('CoreQuestionBundle:Question')->find($id);
        
        return $this->render('QuestionReviewBundle:Display:index.html.twig', array('question'=>$question));
    }
    
    public function editAction($id)
    {
        $form = $this->container->get('question_review.reviewer.form');
        
        $em = $this->getDoctrine()->getEntityManager();
        $question = $em->getRepository('CoreQuestionBundle:Question')->find($id);
        
        $form->setData($question);
        
        $formHandler = $this->container->get('question_review.reviewer.form.handler');
        
        if($formHandler->process(true)){
            
            echo 'valid';
            exit;
            //return new RedirectResponse($this->generateUrl('question_create_success'));
            
        }
        
        return $this->render('QuestionReviewBundle:Display:edit.html.twig', array(
            'form' => $form->createView(),
            'question'=>$question
        ));
    }
}
