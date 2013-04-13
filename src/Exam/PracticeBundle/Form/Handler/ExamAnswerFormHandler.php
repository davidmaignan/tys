<?php

/*
 * This file is part of the QuestionCreateBundle package.
 *
 * (c) Testyrskills.com <http://www.Testyrskills.com/>
 *
 */

namespace Exam\PracticeBundle\Form\Handler;

//use FOS\UserBundle\Model\UserManagerInterface;
//use FOS\UserBundle\Model\UserInterface;

//use Question\CreateBundle\Model\QuestionManagerInterface;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Exam\CoreBundle\Model\ExamAnswerManagerInterface;


class ExamAnswerFormHandler
{
    
    protected $request;
    protected $form;
    protected $examAnswerManager;
    protected $mailer;
    
    public function __construct(FormInterface $form, 
                                Request $request, 
                                ExamAnswerManagerInterface $examAnswerManager)
    {
        $this->form    = $form;
        $this->request = $request;  
        $this->examAnswerManager = $examAnswerManager;
    }
    
    public function process($confirmation = false){
        
        $examAnswer = $this->createExamAnswer();
        $examAnswer = new \Exam\CoreBundle\Entity\ExamAnswer();
        $examAnswer->setUser();
        $examAnswer->setQuestion();
        $examAnswer->setExam();
        $examAnswer->setAnswer();
        
        var_dump(get_class($examAnswer));
        
        var_dump($this->request->get('question_create_contributor_form'));
        
        
        if ('POST' === $this->request->getMethod()) {
            
            $this->form->bind($this->request);
            
            if ($this->form->isValid()) {
                echo 'valid';
            }else {
                echo 'form invalid';
            }

        }
        
    }
    
    /**
     * @return ExamCriteriaInterface
    */
    protected function createExamAnswer()
    {
        return $this->examAnswerManager->createExamAnswer();
    }
}
