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


class ExamGenerateFormHandler
{
    
    protected $request;
    protected $form;
    protected $examCriteriaManager;
    protected $mailer;
    
    public function __construct(FormInterface $form, 
                                Request $request, 
                                ExamCriteriaManagerInterface $examCriteriaManager,
                                SecurityContext $securityContext)
    {
        $this->form = $form;
        $this->request = $request;
        $this->examCriteriaManager = $examCriteriaManager;
        $this->securityContext = $securityContext;
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
    protected function onSuccess(ExamCriteriaInterface$examCriteria, $confirmation)
    {
        $this->examCriteriaManager->updateExamCriteria($examCriteria);
        
        echo 'here';
        exit;
        
    }
    
    
     /**
     * @return QuestionInterface
     */
    protected function createExamCriteria()
    {
        return $this->examCriteriaManager->createExamCriteria();
    }
   
}
