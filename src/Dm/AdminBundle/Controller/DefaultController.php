<?php

namespace Dm\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        
       $em = $this->getDoctrine()->getEntityManager();
        
       $results = $em->createQueryBuilder()
                     ->select('COUNT (b.id)')
                     ->from('DmQuestionBundle:Question', 'b')
                     ->getQuery()
                     ->getResult();
                         
        
       //var_dump($results);
       //exit;
        
        
        return $this->render('DmAdminBundle:Default:index.html.twig');
    }
}
