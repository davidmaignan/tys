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
use Doctrine\ORM\EntityManager;

use Exam\CoreBundle\Entity\Exam;
use Exam\CoreBundle\Entity\ExamQuestion;


class ExamGenerateFormHandler
{
    
    protected $request;
    protected $form;
    protected $examCriteriaManager;
    protected $examManager;
    protected $mailer;
    protected $user;
    protected $em;
    
    
    public function __construct(FormInterface $form, 
                                Request $request, 
                                ExamCriteriaManagerInterface $examCriteriaManager,
                                ExamManagerInterface $examManager,
                                SecurityContext $securityContext,
                                EntityManager $em)
    {
        $this->form                 = $form;
        $this->request              = $request;
        $this->examCriteriaManager  = $examCriteriaManager;
        $this->examManager          = $examManager;
        $this->securityContext      = $securityContext;
        $this->em                   = $em;
        
        $this->user = $this->securityContext->getToken()->getUser();
    }
    
    
    public function process($confirmation = false)
    {
        $examCriteria = $this->createExamCriteria();
        
        $this->form->setData($examCriteria);
        
        if ('POST' === $this->request->getMethod()) {
            

            $this->form->bind($this->request);
                     
            if ($this->form->isValid()) {
                $this->onSuccess($examCriteria, $confirmation);
                return true;
            }
        }

    }
    
    /**
     * @param boolean $confirmation
     */
    protected function onSuccess(ExamCriteriaInterface $examCriteria, $confirmation)
    {
        $questions = $this->em->getRepository('CoreQuestionBundle:Question')->findAll();
        
        $listQuestionsKeys = array_rand($questions, 10);
        
        $examQuestion = new ExamQuestion();
        
        foreach ($listQuestionsKeys as $value) {
            $examQuestion->addQuestion($questions[$value]);
            $questions[$value]->addExamQuestion($examQuestion);
            $this->em->persist($questions[$value]);
        }
        
        $exam = $this->createExam();
        
        $exam = new Exam();
        $exam->setOwner($this->user);
        $exam->setCriteria($examCriteria);
        
        $examCriteria->setExam($exam);
        $examCriteria->setExamQuestion($examQuestion);
        $examQuestion->setExamCriteria($examCriteria);
        
        $this->em->persist($examQuestion);
        
        
        $this->examCriteriaManager->updateExamCriteria($examCriteria);
        $this->examManager->updateExam($exam);
        
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
