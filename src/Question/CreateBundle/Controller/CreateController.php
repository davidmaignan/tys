<?php

namespace Question\CreateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Core\QuestionBundle\Entity\Question;
use Core\QuestionBundle\Form\QuestionType;

use Core\LevelBundle\Entity\Level;
use Core\LevelBundle\Form\LevelFormType;

class CreateController extends Controller
{
    public function indexAction()
    {
        
        $form = $this->container->get('question_create.contributor.form');
        $formHandler = $this->container->get('question_create.contributor.form.handler');
        
        $formHandler->process();
      
        return $this->render('QuestionCreateBundle:Create:index.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
    public function testAction()
    {
        
        $level = new Level();
        $form = $this->createForm(new LevelFormType(), $level);
        
        //$question = new Question(); 
        //$form = $this->createForm(new QuestionType(), $question);
        
        $request = $this->getRequest();

        if ($request->getMethod() == 'POST') {

            $form->bindRequest($request);

            if ($form->isValid()) {
                echo 'valid';
            }
        }

        
        return $this->render('QuestionCreateBundle:Create:test.html.twig', array('form' => $form->createView()));
        
    }
}
