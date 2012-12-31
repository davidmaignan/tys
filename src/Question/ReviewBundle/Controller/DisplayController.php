<?php

namespace Question\ReviewBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Core\QuestionBundle\Entity\QuestionStatus;

use JMS\SecurityExtraBundle\Annotation\Secure;

class DisplayController extends Controller
{
    
    /**
     * @Secure(roles="ROLE_REVIEWER")
     */
    public function showAction($id)
    {
        
        $em = $this->getDoctrine()->getEntityManager();
        
        $question = $em->getRepository('CoreQuestionBundle:Question')->findOneBy(array('id'=>$id, 'status'=> QuestionStatus::REVIEW));
        
        if(!$question){
            throw $this->createNotFoundException('The question does not exist or it\'s not ready waiting for review');
        }
        
        return $this->render('QuestionReviewBundle:Display:show.html.twig', array('question'=>$question));
    }
    
    /**
     * @Secure(roles="ROLE_REVIEWER")
     */
    public function editAction($id)
    {
        $form = $this->container->get('question_review.reviewer.form');
        $commentForm = $this->container->get('question_review.comment.form');
        
        $em = $this->getDoctrine()->getEntityManager();
        $question = $em->getRepository('CoreQuestionBundle:Question')->findOneBy(array('id'=>$id, 'status'=> QuestionStatus::REVIEW));
        
        if(!$question){
            throw $this->createNotFoundException('The question does not exist or it\'s not ready waiting for review');
        }
        
        $form->setData($question);
        $formHandler = $this->container->get('question_review.reviewer.form.handler');
        
        if($formHandler->process(true, $question)){
            $this->get('session')->setFlash('notice', 'Your changes were saved!'); 
        }
        
        return $this->render('QuestionReviewBundle:Display:edit.html.twig', array(
            'form' => $form->createView(),
            'question'=>$question,
            'commentForm'=>$commentForm->createView()
        ));
    }
}
