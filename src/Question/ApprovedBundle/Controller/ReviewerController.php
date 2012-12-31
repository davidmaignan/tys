<?php

namespace Question\ApprovedBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use JMS\SecurityExtraBundle\Annotation\Secure;

use Core\QuestionBundle\Entity\Question;
use Core\QuestionBundle\Entity\QuestionStatus;

class ReviewerController extends Controller
{
    /**
     * @Secure(roles="ROLE_REVIEWER")
     */
    public function approvedAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $question = $em->getRepository('CoreQuestionBundle:Question')->findOneBy(array('id'=>$id, 'status'=>  QuestionStatus::REVIEW));
        
        if(!$question)
        {
            throw $this->createNotFoundException('The question does not exist or it\'s not ready for approval');
        }      
        
        $question->setStatus(QuestionStatus::APPROVED);
        $em->flush();
        
        $this->get('my_mailer')->sendQuestionApprovedEmail($question);
        
        return $this->redirect($this->generateUrl('question_review_list'));
        
    }
}
