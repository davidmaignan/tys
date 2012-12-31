<?php

namespace Question\ReviewBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use JMS\SecurityExtraBundle\Annotation\Secure;

use Core\QuestionBundle\Entity\QuestionStatus;

class ApprovalController extends Controller
{
    public function indexAction($id)
    {
        //Check credential
        
        //Check question
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();
        
        $result = $em->getRepository('CoreQuestionBundle:Question')->updateStatusApproval($id, $user->getId(), QuestionStatus::PENDING);
        
        if($result === 0){
            throw $this->createNotFoundException('The question does not exist or it\'s already pending for approval');
        }
        
        $question = $em->getRepository('CoreQuestionBundle:Question')->find($id);
        
        $mailer = $this->get('my_mailer');
        $mailer->sendQuestionReviewEmail($question);
        
        return $this->redirect($this->generateUrl('question_owner_list'));
    }
}
