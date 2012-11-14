<?php

/*
 * This file is part of the QuestionCreateBundle package.
 *
 * (c) Testyrskills.com <http://www.Testyrskills.com/>
 *
 */

namespace Exam\GenerateBundle\Form\Handler;

//use FOS\UserBundle\Model\UserManagerInterface;
//use FOS\UserBundle\Model\UserInterface;

//use Question\CreateBundle\Model\QuestionManagerInterface;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Exam\CoreBundle\Model\ExamCriteriaManagerInterface;
use Exam\CoreBundle\Entity\ExamCriteriaInterface;
use Exam\CoreBundle\Model\ExamManagerInterface;


class ExamGenerateFormHandler
{
    
    protected $request;
    protected $form;
    protected $examCriteriaManager;
    protected $examManager;
    protected $mailer;
    protected $user;
    
    public function __construct(FormInterface $form, 
                                Request $request, 
                                ExamCriteriaManagerInterface $examCriteriaManager,
                                ExamManagerInterface $examManager,
                                SecurityContext $securityContext)
    {
        $this->form                 = $form;
        $this->request              = $request;
        $this->examCriteriaManager  = $examCriteriaManager;
        $this->examManager          = $examManager;
        $this->securityContext      = $securityContext;
        
        $this->user = $this->securityContext->getToken()->getUser();
    }
    
    public function process($confirmation = false)
    {
        $examCriteria = $this->createExamCriteria();
        
        $this->form->setData($examCriteria);
        
        if ('POST' === $this->request->getMethod()) {
            
            //var_dump($examCriteria);

            $this->form->bind($this->request);
                     
            if ($this->form->isValid()) {
                echo 'valid';
                $this->onSuccess($examCriteria, $confirmation);
                //return true;
            }else{
                echo 'invalid';
            }
            //exit;
        }

        //return false;
        
        
       
       
    }
    
    /**
     * @param boolean $confirmation
     */
    protected function onSuccess(ExamCriteriaInterface $examCriteria, $confirmation)
    {
        $exam = $this->createExam();
        
        $exam = new \Exam\CoreBundle\Entity\Exam();
        $exam->setCriteria($examCriteria);
        $exam->setOwner($this->user);
        
        $this->examCriteriaManager->updateExamCriteria($examCriteria);
        $this->examManager->updateExam($exam);
        
        //$this->examCriteriaManager->updateExamCriteria($examCriteria);
        
        if($confirmation){
            
        }
        

    }
    
    /**
     * @return ExamInterface
    */
    protected function createExam()
    {
        return $this->examManager->createExam();
    }
    
    /**
     * @return ExamCriteriaInterface
    */
    protected function createExamCriteria()
    {
        return $this->examCriteriaManager->createExamCriteria();
    }
   
}
