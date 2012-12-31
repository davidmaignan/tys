<?php

namespace Question\FeedbackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

use JMS\SecurityExtraBundle\Annotation\Secure;

use Core\QuestionBundle\Entity\QuestionStatus;

class OwnerController extends Controller
{
    
    /**
     * @Secure(roles="ROLE_OWNER")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $user = $this->get('security.context')->getToken()->getUser();
        
        $questions = $em->getRepository('CoreQuestionBundle:Question')->findBy(array('user' =>$user->getId(), 'status'=>  QuestionStatus::FEEDBACK));
 
        return $this->render('QuestionFeedbackBundle:Owner:list.html.twig', array('questions'=>$questions));
    }
    
    /**
     * @Secure(roles="ROLE_OWNER")
     */
    public function showAction($id)
    {

        //Retreive the question
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();
        
        $question = $em->getRepository('CoreQuestionBundle:Question')->findOneBy(array('id'=>$id, 'user' =>$user->getId(), 'status'=>  QuestionStatus::FEEDBACK));
  
        if(!$question){
            throw $this->createNotFoundException('The question does not exist or it\'s not ready waiting for your feedback');
        }
 
        return $this->render('QuestionFeedbackBundle:Owner:show.html.twig', array('question'=>$question));
    }
    
    /**
     * @Secure(roles="ROLE_OWNER")
     */
    public function editAction($id)
    {       
        $em = $this->getDoctrine()->getEntityManager();
        $user = $this->get('security.context')->getToken()->getUser();
        $question = $em->getRepository('CoreQuestionBundle:Question')->findOneBy(array('id'=>$id, 'status'=> QuestionStatus::FEEDBACK, 'user'=>$user));
        
        if(!$question){
            throw $this->createNotFoundException('The question does not exist or it\'s not ready waiting for feedback');
        }
        
        $form = $this->container->get('question_review.reviewer.form');
        $commentForm = $this->container->get('question_review.comment.form');
        
        
        $form->setData($question);
        $formHandler = $this->container->get('question_review.reviewer.form.handler');
        
        if($formHandler->process(true, $question)){
            $this->get('session')->setFlash('notice', 'Your changes were saved!'); 
        }
        
        return $this->render('QuestionFeedbackBundle:Owner:edit.html.twig', array(
            'form' => $form->createView(),
            'question'=>$question,
            'commentForm'=>$commentForm->createView()
        ));
    }
}