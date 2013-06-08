<?php
/*
 * This file is part of the CoreAnswerBundle package.
 *
 * 2013 (c) Testyrskills.com <http://www.testyrskills.com/>
 *
 */
namespace Core\TypeBundle\Entity;

use Core\QuestionBundle\Entity\QuestionInterface;

/**
 * @author David Maignan <davidmaignan@gmail.com>
 */
interface TypeInterface {
    
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
     * constructor
     */
    public function __construct();
    
    /**
     * @return string
     */
    public function __toString();
    
    /**
     * @return Doctrine\Common\Collections\Collection
     */
    public function getQuestions();
    
    /**
     * @param Core\QuestionBundle\Entity\QuestionInterface $question
     */
    public function addQuestion(QuestionInterface $question);
    
    /**
     * @param \Core\QuestionBundle\Entity\QuestionInterface $question
     */
    public function removeQuestion(QuestionInterface $question);
}
