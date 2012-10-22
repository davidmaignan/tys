<?php

namespace Question\CreateBundle\Form\Handler;

//use FOS\UserBundle\Model\UserManagerInterface;
//use FOS\UserBundle\Model\UserInterface;

use Question\CreateBundle\Model\QuestionManagerInterface;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;


class QuestionFormHandler
{
    
    protected $request;
    protected $form;
    protected $questionManager;
    
    public function __construct(FormInterface $form, 
                                Request $request, 
                                QuestionManagerInterface $questionManager,
                                SecurityContext $securityContext)
    {
        $this->form = $form;
        $this->request = $request;
        $this->questionManager = $questionManager;
        $this->securityContext = $securityContext;
    }
    
    public function process($confirmation = false)
    {
        
        $question = $this->createQuestion();
        
        //If user is fully authenticated 
        if( $this->securityContext->isGranted('IS_AUTHENTICATED_FULLY') || 
            $this->securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')){
            
              $question->setUser($this->securityContext->getToken()->getUser());
        }
        
        
        $answer = new \Core\AnswerBundle\Entity\Answer();
        $answer->setQuestion($question);
        $question->getAnswers()->add($answer);
        
        
         if ('POST' === $this->request->getMethod()) {
            $form = $this->request->request->get('question_create_contributor_form');

            $total = count($form['answers']);
            
            for($i=0 ; $i<$total ; $i++)
            {
                $answer = new \Core\AnswerBundle\Entity\Answer();
                $answer->setQuestion($question);
                $question->getAnswers()->add($answer);
            }
            
        }

        
        
        $this->form->setData($question);
        
        if ('POST' === $this->request->getMethod()) {

            $this->form->bind($this->request);
                     
            if ($this->form->isValid()) {
                $this->onSuccess($question, $confirmation);
                return true;
            }
        }

        return false;
        
    }
    
    /**
     * @param boolean $confirmation
     */
    protected function onSuccess($question, $confirmation)
    {
        if ($confirmation) {
            
            $this->mailer->sendConfirmationEmailMessage($level);
        } else {
            //$level->setEnabled(true);
        }

        $this->questionManager->updateQuestion($question);
    }
    
     /**
     * @return QuestionInterface
     */
    protected function createQuestion()
    {
        return $this->questionManager->createQuestion();
    }
}
