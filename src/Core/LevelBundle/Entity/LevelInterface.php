<?php

/*
 * This file is part of the CoreLevelBundle package.
 *
 * 2013 (c) Testyrskills.com <http://www.testyrskills.com/>
 *
 */
namespace Core\LevelBundle\Entity;

use Core\QuestionBundle\Entity\QuestionInterface;

interface LevelInterface
{   
    /**
     * constructor
     */
    public function __construct();
    
    /**
     * @return string;
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
     * 
     * @param \Core\QuestionBundle\Entity\Question $question
     */
    public function addQuestion(QuestionInterface $question);
    
    /**
     * 
     * @param \Core\QuestionBundle\Entity\QuestionInterface $question
     */
    public function removeQuestion(QuestionInterface $question);
    
    /**
     * @return Doctrine\Common\Collections\Collection
     */
    public function getQuestions();
}
