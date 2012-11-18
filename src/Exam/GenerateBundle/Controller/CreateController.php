<?php

namespace Exam\GenerateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CreateController extends Controller
{
    public function indexAction()
    {
        $form = $this->container->get('exam_generate.form');
        $formHandler = $this->container->get('exam_generate.form.handler');
        
         if($formHandler->process(true)){
             
             return new RedirectResponse($this->generateUrl('exam_manage_homepage'));
             
         }
        
        return $this->render('ExamGenerateBundle:Create:index.html.twig',array('form'=>$form->createView()));
    }
}
