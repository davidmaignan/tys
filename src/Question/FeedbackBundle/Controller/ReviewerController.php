<?php

namespace Question\FeedbackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

use JMS\SecurityExtraBundle\Annotation\Secure;

use Core\QuestionBundle\Entity\QuestionStatus;

class ReviewerController extends Controller
{
    
    /**
     * @Secure(roles="ROLE_REVIEWER")
     */
    public function feedbackAction($id)
    {
        
        //Check credential

        //Check question
        $em = $this->getDoctrine()->getManager();
        //$question = $em->getRepository('CoreQuestionBundle:Question')->find($id);
        
        $result = $em->getRepository('CoreQuestionBundle:Question')->updateStatus($id, QuestionStatus::FEEDBACK);
        
        if($result === 0){
            throw $this->createNotFoundException('The question does not exist or it\'s already pending for feedback');
        }
        
        $question = $em->getRepository('CoreQuestionBundle:Question')->find($id);
        
        $mailer = $this->get('my_mailer');
        $mailer->sendQuestionFeedbackEmail($question);

        return $this->redirect($this->generateUrl('question_review_list'));
    }
    
    
}
