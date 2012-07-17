<?php

namespace Dm\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class QuestionController extends Controller
{
    public function indexAction()
    {
        
        $em = $this->getDoctrine()->getEntityManager();
        
        $questions = $em->createQueryBuilder()
                        ->select('b')
                        ->from('DmQuestionBundle:Question', 'b')
                        ->getQuery()
                        ->getResult();
        
        return $this->render('DmAdminBundle:Question:index.html.twig', array('questions'=>$questions));
    }
}
