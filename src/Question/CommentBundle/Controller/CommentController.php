<?php

namespace Question\CommentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Core\QuestionBundle\Entity\QuestionStatus;
use JMS\SecurityExtraBundle\Annotation\Secure;


class CommentController extends Controller
{
    
    /**
     * @Secure(roles="ROLE_REVIEWER, ROLE_OWNER")
     */
    public function createAction($id)
    {   
                
        $em = $this->getDoctrine()->getEntityManager();
        $question = $em->getRepository('CoreQuestionBundle:Question')->findOneBy(array('id'=>$id, 'status'=> array(QuestionStatus::REVIEW, QuestionStatus::FEEDBACK)));
        
        if(!$question){
            throw $this->createNotFoundException('The question does not exist or it\'s not commentable');
        }
        
        //Case ROLE_OWNER
        $user = $this->get('security.context')->getToken()->getUser();        
        $roles = $user->getRoles();

        if(in_array('ROLE_OWNER', $roles) && $question->getUser() !== $user){
            throw new AccessDeniedException('You don\'t have the credentials to leave a comment for this question');
        }
        
        $commentForm = $this->container->get('question_review.comment.form');
        $commentFormHandle = $this->container->get('question_review.comment.form.handler');
        $commentFormHandle->process($question, true);
        
        if(in_array('ROLE_OWNER', $roles)){
            $route = 'question_feedback_edit';
        }else{
            $route = 'question_review_edit';
        }
                
        $url = $this->get('router')->generate($route, array(
            'id'=> $id,
        ));
        
        return $this->redirect($url);

    }
    
}