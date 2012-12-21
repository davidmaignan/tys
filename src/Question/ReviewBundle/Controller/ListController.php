<?php

namespace Question\ReviewBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ListController extends Controller
{
    public function indexAction()
    {
        
        $em = $this->getDoctrine()->getEntityManager();
        
        $query = $em->getRepository('CoreQuestionBundle:Question')->findByReviewerRole();
        
        $questions = $query->getQuery()->getResult();
        
        return $this->render('QuestionReviewBundle:List:index.html.twig', array('questions'=>$questions));
    }
}
