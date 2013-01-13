<?php

namespace Question\CreateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Core\QuestionBundle\Entity\Question;
use Core\QuestionBundle\Form\QuestionType;

use Core\LevelBundle\Entity\Level;
use Core\LevelBundle\Form\LevelFormType;
use Security\AuthenticateBundle\Entity\User;

class CreateController extends Controller
{
    public function indexAction()
    {
        
        $form = $this->container->get('question_create.contributor.form');
        $formHandler = $this->container->get('question_create.contributor.form.handler');
        
        if($formHandler->process(true)){
            
            //Add role ROLE_OWNER if not already
            $user = $this->get('security.context')->getToken()->getUser();
            $user = new Security\AuthenticateBundle\Entity\User();
            
            if(!in_array('ROLE_OWNER', $user->getRoles())){
                $user->set
            }
            
            return new RedirectResponse($this->generateUrl('question_create_success'));
            
        }
      
        return $this->render('QuestionCreateBundle:Create:index.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
    public function successAction()
    {
        return $this->render('QuestionCreateBundle:Create:Success.html.twig');
    }
    
}
