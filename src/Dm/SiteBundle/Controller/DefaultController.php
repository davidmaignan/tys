<?php

namespace Dm\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Core\QuestionBundle\Entity\QuestionStatus;
use Core\QuestionBundle\Entity\Question;

class DefaultController extends Controller
{
    /**
     * Homepage
     * @return type 
     */
    public function indexAction()
    {   
        $em = $this->getDoctrine()->getEntityManager();
        
        //$question = new Question();
        //$question->setTitle("test");
        
        //$em->persist($question);
        //$em->flush();
        
        //$question = $em->getRepository('CoreQuestionBundle:Question')->find(311);
        //var_dump($question);
        
        //$question->setStatus(2);
        //$em->persist($question);
        //$em->flush();
        
        
        return $this->render('DmSiteBundle:Default:index.html.twig');
    }
}
