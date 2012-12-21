<?php

namespace Question\ReviewBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CommentController extends Controller
{
    
    public function createAction($id)
    {
        
        $em = $this->getDoctrine()->getEntityManager();
        $question = $em->getRepository('CoreQuestionBundle:Question')->find($id);
        
        $commentForm = $this->container->get('question_review.comment.form');
        $commentFormHandle = $this->container->get('question_review.comment.form.handler');
        
        $commentFormHandle->process($question, true);
                
        $url = $this->get('router')->generate('question_reviewer_edit', array(
            'id'=> $id,
        ));
        
        return $this->redirect($url);
        //exit;
        
    }
    
}