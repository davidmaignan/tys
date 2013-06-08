<?php

/*
 * This file is part of the CoreAnswerBundle package.
 *
 * (c) Testyrskills.com <http://www.testyrskills.com/>
 *
 */

namespace Core\AnswerBundle\Entity;

use Core\QuestionBundle\Entity\Question;

/**
 * @author David Maignan <davidmaignan@gmail.com>
 */
interface AnswerInterface {
    
    /**
     * @return integer
     */
    public function getId();
    
    /**
     * @param string $title
     */
    public function setTitle($title);
    
    /**
     * @return string
     */
    public function getTitle();
    
    /**
     * @param \Core\QuestionBundle\Entity\QuestionInterface $question
     */
    public function setQuestion(Question $question);
    
    /**
     * @return \Core\QuestionBundle\Entity\Question
     */
    public function getQuestion();
    
    /**
     * @param string $code
     */
    public function setCode($code);
    
    /**
     * @return string
     */
    public function getCode();
    
    /**
     * @param boolean
     */
    public function setCorrect($correct);
    
    /**
     * @return boolean
     */
    public function getCorrect();
    
    /**
     * Constructor
     */
    public function __toString();
    
}
