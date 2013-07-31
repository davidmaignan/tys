<?php

namespace Exam\CoreBundle\Entity;

interface ExamAnswerInterface {
    /**
     * @param \Security\AuthenticateBundle\Entity\User $user
     */
    public function setUser(\Security\AuthenticateBundle\Entity\User $user = null);
    
    /**
     * @param \Security\AuthenticateBundle\Entity\User $user
     */
    public function getUser();
    
    /**
     * @param \Core\QuestionBundle\Entity\QuestionInterface $question
     */
    public function setQuestion(\Core\QuestionBundle\Entity\QuestionInterface $question = null);
    
    /**
     * @return \Core\QuestionBundle\Entity\QuestionInterface
     */
    public function getQuestion();
    
    /**
     * @param \Core\AnswerBundle\Entity\AnswerInterface $answer
     */
    public function setAnswer(\Core\AnswerBundle\Entity\AnswerInterface $answer = null);
    
    /**
     * @return \Core\AnswerBundle\Entity\AnswerInterface
     */
    public function getAnswer();
    
    /**
     * @param \Exam\CoreBundle\Entity\CriteriaQuestionInterface $criteriaQuestion
     */
    public function setCriteriaQuestion(\Exam\CoreBundle\Entity\CriteriaQuestionInterface $criteriaQuestion = null);
    
    /**
     * @return \Exam\CoreBundle\Entity\CriteriaQuestionInterface
     */
    public function getCriteriaQuestion();
}