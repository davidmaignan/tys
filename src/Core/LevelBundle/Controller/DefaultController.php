<?php

namespace Core\LevelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Core\LevelBundle\Entity\Level;


class DefaultController extends Controller
{
    public function indexAction()
    {
        
        $levelFormView = $this->getComponentFormView();
        
        return $this->render('CoreLevelBundle:Default:index.html.twig',
                array('form'    => $levelFormView
                    )
               );
    }
    
}
