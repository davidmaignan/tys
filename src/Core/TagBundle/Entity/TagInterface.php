<?php
/*
 * This file is part of the CoreAnswerBundle package.
 *
 * 2013 (c) Testyrskills.com <http://www.testyrskills.com/>
 *
 */

namespace Core\TagBundle\Entity;

use Core\QuestionBundle\Entity\QuestionInterface;
use Exam\CoreBundle\Entity\ExamCriteriaInterface;

/**
 * @author David Maignan <davidmaignan@gmail.com>
 */

interface TagInterface {
    
    /**
     * constructor
     */
    public function __construct();
    
    /**
     * @return string
     */
    public function __toString();
    
    /**
     * @return integer 
     */
    public function getId();
    
    /**
     * @param string
     */
    public function setName($name);
    
    /**
     * @return string
     */
    public function getName();
    
    /**
     * @param \Core\QuestionBundle\Entity\QuestionInterface $question
     */
    public function addQuestion(QuestionInterface $question);
    
    /**
     * @param \Core\QuestionBundle\Entity\QuestionInterface $question
     */
    public function removeQuestion(QuestionInterface $question);
    
    /**
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getQuestions();
    
    /**
     * @param \Core\TagBundle\Entity\ExamCriteriaInterface $examCriteria
     */
    public function addExamCriteria(ExamCriteriaInterface $examCriteria);
    
    /**
     * @param \Core\TagBundle\Entity\ExamCriteriaInterface $examCriteria
     */
    public function removeExamCriteria(ExamCriteriaInterface $examCriteria);
    
    /**
     * @return Doctrine\Common\Collections\Collection
     */
    public function getExamCriterias();
}

