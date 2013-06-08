<?php

/*
 * This file is part of the CoreAnswerBundle package.
 *
 * 2013 (c) Testyrskills.com <http://www.testyrskills.com/>
 *
 */

namespace Core\AnswerBundle\Doctrine;

use Core\AnswerBundle\Entity\AnswerInterface;

/**
 * Answer Manager Interface
 * 
 * All changes to answers should happen through this interface.
 *
 * @author David Maignan <davidmaignan@gmail.com>
 */

interface AnswerManagerInterface {
    
    /**
     * Returns an empty answer instance
     *
     * @return AnswerInterface
     */
    public function createAnswer();
    
    /**
     * 
     * @param type $class
     */
    public function supportsClass($class);
    
    /**
     * Delete an answer instance
     * 
     * @param \Core\AnswerBundle\Entity\AnswerInterface $answer
     */
    public function deleteAnswer(AnswerInterface $answer);
    
    /**
     * Get class
     * 
     * @return string class name
     */
    public function getClass();
    
    /**
     * Finds one answer by the given criteria.
     *
     * @param array $criteria
     *
     * @return AnswerInterface
     */
    public function findAnswerBy(array $criteria);
    
    /**
     * Returns a collection with all answer instances.
     *
     * @return \Traversable
     */
    public function findAnswers();
    
    /**
     * Updates an answer.
     *
     * @param AnswerInterface $answer
     * @param Boolean         $andFlush
     *
     * @return void
     */
    public function updateAnswer(AnswerInterface $answer, $andFlush = true);
    
}
