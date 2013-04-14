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
use Exam\CoreBundle\Model\ExamManagerInterface;
use Question\CreateBundle\Model\QuestionManagerInterface;
use Core\AnswerBundle\Doctrine\AnswerManagerInterface;


class ExamAnswerFormHandler
{
    /**
     *
     * @var type Symfony\Component\HttpFoundation\Request 
     */
    protected $request;
    
    /**
     *
     * @var type Symfony\Component\Security\Core\SecurityContext
     */
    protected $security;
    
    /**
     *
     * @var type Symfony\Component\Form\FormInterface
     */
    protected $form;
    
    /**
     *
     * @var type Exam\CoreBundle\Model\ExamManagerInterface;
     */
    protected $examManager;
    
    /**
     *
     * @var type Exam\CoreBundle\Doctrine\ExamAnswerManager
     */
    protected $examAnswerManager;
    
    /**
     *
     * @var type Question\CreateBundle\Model\QuestionManager
     */
    protected $questionManager;
    
    /**
     *
     * @var type Core\AnswerBundle\Doctrine\AnswerManager
     */
    protected $answerManager;


    public function __construct(FormInterface $form, 
                                Request $request, 
                                SecurityContext $securityContext,
                                ExamAnswerManagerInterface $examAnswerManager,
                                ExamManagerInterface $examManager,
                                QuestionManagerInterface $questionManager,
                                AnswerManagerInterface$answerManager)
    {
        $this->form              = $form;
        $this->request           = $request;  
        $this->security          = $securityContext;
        $this->examManager       = $examManager;
        $this->examAnswerManager = $examAnswerManager;
        $this->questionManager   = $questionManager;
        $this->answerManager     = $answerManager;
    }
    
    /**
     * Process the examAnswer Form
     * @param type $confirmation
     */
    public function process(){
        
        if ('POST' === $this->request->getMethod()) {
            
            $examAnswer = $this->createExamAnswer();
            
            $examAnswer->setUser($this->getUser());
            $examAnswer->setQuestion($this->getQuestion());
            $examAnswer->setExam($this->getExam());
            
            $this->form->bind($this->request);
            
            if ($this->form->isValid()) {
                
                $values = $this->request->get('exam_answer_form');
                $answerId = $values['answer'];
                
                $answer = $this->getAnswer($answerId);
                
                $examAnswer->setAnswer($answer);
                
                $this->examAnswerManager->updateExamAnswer($examAnswer);  
                 
                //Get the next question
                $this->getNextQuestion();
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
    
    /**
     * 
     * @return type Secutiry\AuthenticateBundle\Entity\User
     */
    private function getUser() {
        return $this->security->getToken()->getUser();
    }
    
    /**
     * Return Exam entity
     * 
     * @return type Exam\CoreBundle\Entity\Exam
     */
    private function getExam() {
        $criteria = $this->request->getSession()->get('exam');
        
        return $this->examManager->findExamBy($criteria);
    }
    
    private function getQuestion() {
        $criteria = $this->request->getSession()->get('question');
        
        return $this->questionManager->findQuestionBy($criteria);
    }
    
    private function getAnswer($answerId) {
        $criteria = $this->request->getSession()->get('question');
        
        return $this->answerManager->findAnswerBy(array('id'=>$answerId));
    }
    
    private function getNextQuestion() {
        
        $exam = $this->getExam();
        
        $criteria = $this->request->getSession()->get('question');
        $questionId = $criteria['id'];
        
        $questions = $exam->getExamCriteria()->getExamQuestion()->getQuestions();
        
        foreach ($questions as $key => $value) {
            
            if($value->getId() == $questionId){
                
                $nextQuestion = $questions[$key + 1];
                
                if(null === $nextQuestion){
                    $this->request->getSession()->remove('question');
                }else{
                    $this->request->getSession()->set('question', array('id'=> $nextQuestion->getId()));
                }
                
                return;
            }
        }
    }
}
