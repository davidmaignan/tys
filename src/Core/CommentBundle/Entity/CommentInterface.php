<?php
/*
 * This file is part of the CoreCommentBundle package.
 *
 * 2013 (c) Testyrskills.com <http://www.testyrskills.com/>
 *
 */

namespace Core\CommentBundle\Entity;

use Core\QuestionBundle\Entity\Question;
use Security\AuthenticateBundle\Entity\User;

/**
 * @author David Maignan <davidmaignan@gmail.com>
 */

interface CommentInterface {
    
    /**
     * @return integer
     */
    public function getId();
    
    /**
     * @param string
     */
    public function setBody($body);
    
    /**
     * @return string
     */
    public function getBody();
    
    /**
     * @param \DateTime
     */
    public function setCreatedAt($date);
    
    /**
     * @return \DateTime
     */
    public function getCreatedAt();
    
    /**
     * @param \DateTime
     */
    public function setUpdatedAt($date);
    
    /**
     * @return \DateTime
     */
    public function getUpdatedAt();
    
    /**
     * @param \Core\QuestionBundle\Entity\Question
     */
    public function setQuestion(Question $question = null);
    
    /**
     * @resturn \Core\QuestionBundle\Entity\Question
     */
    public function getQuestion();
    
    /**
     * @param \Security\AuthenticateBundle\Entity\User
     */
    public function setUser(User $user = null);
    
    /**
     * @return \Security\AuthenticateBundle\Entity\User
     */
    public function getUser();
}