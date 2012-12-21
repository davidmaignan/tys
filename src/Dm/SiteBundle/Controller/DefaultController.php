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
        
        $question = $em->getRepository('CoreQuestionBundle:Question')->find(317);
        //var_dump($question);
        
        //$question->setStatus(2);
        //$em->persist($question);
        //$em->flush();
        
        $user = $this->get('security.context')->getToken()->getUser();
        
        $comment = new \Core\CommentBundle\Entity\Comment();
        $comment->setBody('test comment homepage');
        $em->persist($comment);
        $em->flush();
        
        
        return $this->render('DmSiteBundle:Default:index.html.twig');
    }
}
