<?php

namespace Security\AuthenticateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Core\QuestionBundle\Entity\Question;
use Core\QuestionBundle\Form\QuestionType;

use Core\LevelBundle\Entity\Level;
use Core\LevelBundle\Form\LevelFormType;

class DeleteController extends Controller
{
    public function indexAction($id)
    {
        
        $user = $this->get('fos_user.user_manager')->findUserBy(array('id'=>$id));
        
        echo $user;
        //exit;
        
        $userDelete = $this->get('fos_user.user_manager')->deleteUser($user);
        
        echo 'Delete: ' .$id;
        exit;
    }
}
