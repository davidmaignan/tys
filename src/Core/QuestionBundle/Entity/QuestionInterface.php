<?php

/*
 * This file is part of the CoreAnswerBundle package.
 *
 * 2013 (c) Testyrskills.com <http://www.testyrskills.com/>
 *
 */

namespace Core\QuestionBundle\Entity;

/**
 * @author David Maignan <davidmaignan@gmail.com>
 */

use Doctrine\Common\Collections\ArrayCollection;

use Core\TagBundle\Entity\TagInterface;
use Core\AnswerBundle\Entity\AnswerInterface;
use Security\AuthenticateBundle\Entity\User;
use Exam\CoreBundle\Entity\ExamInterface;
use Core\CommentBundle\Entity\CommentInterface;
use Exam\CoreBundle\Entity\ExamQuestionInterface;


interface QuestionInterface {
    
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
    public function setTitle($title);
    
    /**
     * @return string
     */
    public function getTitle();
    
    /**
     * @return string
     */
    public function getCode();
    
    /**
     * @param string
     */
    public function setCode($code);
    
    /**
     * @param string
     */
    public function setNote($note);
    
    /**
     * @return string
     */
    public function getNote();
    
    /**
     * @param integer
     */
    public function setSection($section);
    
    /**
     * @return integer
     */
    public function getSection();
    
    /**
     * @param integer
     */
    public function setLevel($level);
    
    /**
     * @return integer
     */
    public function getLevel();
    
    /**
     * @param integer
     */
    public function setType($type);
    
    /**
     * @return integer
     */
    public function getType();
    
    /**
     * @param integer
     */
    public function setPoints($points);
    
    /**
     * @return integer
     */
    public function getPoints();
    
    /**
     * @param Core\TagBundle\Entity\TagInterface
     */
    public function addTag(TagInterface $tag);
    
    /**
     * @param Core\TagBundle\Entity\TagInterface
     */
    public function removeTag(TagInterface $tag);
    
    /**
     * @return Doctrine\Common\Collections\Collection
     */
    public function getTags();
    
    /**
     * @param \Core\AnswerBundle\Entity\AnswerInterface
     */
    public function addAnswer(AnswerInterface $answer);
    
    /**
     * @param \Core\AnswerBundle\Entity\AnswerInterface
     */
    public function removeAnswer(AnswerInterface $answer);
    
    /**
     * @return Doctrine\Common\Collections\Collection
     */
    public function getAnswers();
    
    /**
     * @param \Core\QuestionBundle\Entity\ArrayCollection
     */
    public function setAnswers(ArrayCollection $answers);
    
    /**
     * @param \DateTime
     */
    public function setCreatedAt($createdAt);
    
    /**
     * @return \DateTime
     */
    public function getCreatedAt();
    
    /**
     * @param \DateTime
     */
    public function setUpdatedAt($updatedAt);
    
    /**
     * @return \DateTime
     */
    public function getUpdatedAt();
    
    /**
     * @param \Core\QuestionBundle\Entity\User
     */
    public function setUser(User $user = null);
    
    /**
     * @return \Core\QuestionBundle\Entity\User
     */
    public function getUser();
    
    /**
     * @param \Core\QuestionBundle\Entity\ExamInterface $exam
     */
    public function addExam(ExamInterface $exam);
    
    /**
     * @param \Core\QuestionBundle\Entity\ExamInterface $exam
     */
    public function removeExam(ExamInterface $exam);
    
    /**
     * @return \Core\QuestionBundle\Entity\ArrayCollection
     */
    public function getExams();
    
    /**
     * @param integer
     */
    public function setStatus($status);
    
    /**
     * @return integer
     */
    public function getStatus();
    
    /**
     * @param \Core\QuestionBundle\Entity\CommentInterface
     */
    public function addComment(CommentInterface $comment);
    
    /**
     * @param \Core\QuestionBundle\Entity\CommentInterface
     */
    public function removeComment(CommentInterface $comment);
    
    /**
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getComments();
    
    /**
     * @param \Core\QuestionBundle\Entity\QuestionInterface
     */
    public function setHead(QuestionInterface $head = null);
    
    /**
     * @return \Core\QuestionBundle\Entity\QuestionInterface
     */
    public function getHead();
    
    /**
     * @param \Core\QuestionBundle\Entity\QuestionInterface
     */
    public function setTail(QuestionInterface $tail = null);
    
    /**
     * @return \Core\QuestionBundle\Entity\QuestionInterface
     */
    public function getTail();
    
    /**
     * @param \Core\QuestionBundle\Entity\ExamQuestionInterface
     */
    public function addExamQuestion(ExamQuestionInterface $examQuestion);
    
    /**
     * @param \Core\QuestionBundle\Entity\ExamQuestionInterface
     */
    public function removeExamQuestion(ExamQuestionInterface $examQuestion);
    
    /**
     * @return \Core\QuestionBundle\Entity\ArrayCollection
     */
    public function getExamQUestions();
}