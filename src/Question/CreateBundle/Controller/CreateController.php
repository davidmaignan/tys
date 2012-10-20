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
        
        //$formHandler = $this->container->get('fos_user.registration.form.handler');
        //$confirmationEnabled = $this->container->getParameter('fos_user.registration.confirmation.enabled');

        $process = false;
        
        if ($process) {
            $user = $form->getData();

            $authUser = false;
            if ($confirmationEnabled) {
                $this->container->get('session')->set('fos_user_send_confirmation_email/email', $user->getEmail());
                $route = 'fos_user_registration_check_email';
            } else {
                $authUser = true;
                $route = 'fos_user_registration_confirmed';
            }

            $this->setFlash('fos_user_success', 'registration.flash.user_created');
            $url = $this->container->get('router')->generate($route);
            $response = new RedirectResponse($url);

            if ($authUser) {
                $this->authenticateUser($user, $response);
            }

            return $response;
        }
        
        $form2 = $this->container->get('question_create.registration.form');
        $formHandler2 = $this->container->get('question_create.registration.form.handler');
        $formHandler2->process();
        //var_dump($form2);
        //exit;

        return $this->render('QuestionCreateBundle:Create:index.html.twig', array(
            'form' => $form->createView(),
            'form2'=> $form2->createView()
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
