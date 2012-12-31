<?php

namespace Question\ReviewBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;

class ListController extends Controller
{
    
    /**
     * @Secure(roles="ROLE_REVIEWER")
     */
    public function indexAction()
    {
        
        $em = $this->getDoctrine()->getEntityManager();
        
        $languages = $this->get('security.context')->getToken()->getUser()->getReviewerLangages();
        
        $query = $em->getRepository('CoreQuestionBundle:Question')->findByReviewerRole($languages);
        
        $questions = $query->getQuery()->getResult();
        
        return $this->render('QuestionReviewBundle:List:index.html.twig', array('questions'=>$questions));
    }
    
}
