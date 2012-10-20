<?php

namespace Question\CreateBundle\Form\Handler;

//use FOS\UserBundle\Model\UserManagerInterface;
//use FOS\UserBundle\Model\UserInterface;

use Question\CreateBundle\Model\QuestionManagerInterface;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class QuestionFormHandler
{
    
    protected $request;
    protected $form;
    protected $questionManager;
    
    public function __construct(FormInterface $form, Request $request, QuestionManagerInterface $questionManager)
    {
        $this->form = $form;
        $this->request = $request;
        $this->questionManager = $questionManager;      
    }
    
    public function process($confirmation = false)
    {
        
        $question = $this->createQuestion();
        
        //$answer = new \Core\AnswerBundle\Entity\Answer();
        //$question->getAnswers()->add($answer);
        
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
