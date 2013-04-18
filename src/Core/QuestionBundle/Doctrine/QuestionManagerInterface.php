<?php

/*
 * This file is part of the QuestionCreateBundle package.
 *
 * (c) Testyrskills.com <http://www.Testyrskills.com/>
 *
 */

namespace Question\CreateBundle\Model;

/**
 * Interface to be implemented by question manager. This adds an additional level
 * of abstraction between the application, and the actual repository.
 *
 * @author David Maignan <davidmaignan@gmail.com>
 */

use Doctrine\Common\Persistence\ObjectManager;
use Core\QuestionBundle\Entity\QuestionInterface;

interface QuestionManagerInterface
{
    /**
     * Creates an empty question instance.
     *
     * @return UserInterface
     */
    public function createQuestion();
    
    /**
     * 
     * @param type $class
     */
    public function supportsClass($class);
    
    /**
     * 
     * @param Doctrine\Common\Persistence\ObjectManager $om
     * @param type                                      $class
     */
    public function __construct(ObjectManager $om, $class);
    
    /**
     * Delete a question
     * 
     * @param QuestionInterface $question
     */
    public function deleteQuestion(QuestionInterface $question);

    /**
     * Finds one question by the given criteria.
     *
     * @param array $criteria
     *
     * @return QuestionInterface
     */
    public function findQuestionBy(array $criteria);

    /**
     * Returns a collection with all question instances.
     *
     * @return \Traversable
     */
    public function findQuestions();

    /**
     * Returns the question's fully qualified class name.
     *
     * @return string
     */
    public function getClass();

    /**
     * Updates a question.
     *
     * @param QuestionInterface $question
     * @param Boolean       $andFlush Whether to flush the changes (default true)
     * 
     */
    public function updateQuestion(UserInterface $question, $andFlush = true);

}
