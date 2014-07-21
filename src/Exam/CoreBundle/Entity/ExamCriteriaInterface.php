<?php

namespace Exam\CoreBundle\Entity;

interface  ExamCriteriaInterface
{
    /**
     * @param integer $numberCandidates
     */
    public function setNumberCandidates($numberCandidates);
    
    /**
     * @return integer
     */
    public function getNumberCandidates();
    
    /**
     * @param integer $numberQuestions
     */
    public function setNumberQuestions($numberQuestions);
    
    /**
     * @return integer
     */
    public function getNumberQuestions();
    
    /**
     * @param \Core\LevelBundle\Entity\LevelInterface $level
     */
    public function setLevel(\Core\LevelBundle\Entity\LevelInterface $level = null);
    
    /**
     * @return \Core\LevelBundle\Entity\LevelInterface
     */
    public function getLevel();
    
    /**
     * @param \Core\TagBundle\Entity\TagInterface $tag
     */
    public function addTag(\Core\TagBundle\Entity\TagInterface $tag);
    
    /**
     * @param \Core\TagBundle\Entity\Tag $tag
     */
    public function removeTag(\Core\TagBundle\Entity\Tag $tag);
    
    /**
     * @return \Doctrine\Common\Collection\ArrayCollection
     */
    public function getTags();
    
    /**
     * @param \Core\SectionBundle\Entity\Section $section
     */
    public function addSection(\Core\SectionBundle\Entity\Section $section);
    
    /**
     * @param \Core\SectionBundle\Entity\Section $section
     */
    public function removeSection(\Core\SectionBundle\Entity\Section $section);
    
    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSections();
    
    /**
     * @param \Core\TypeBundle\Entity\Type $type
     */
    public function addType(\Core\TypeBundle\Entity\Type $type);
    
    /**
     * @param \Core\TypeBundle\Entity\Type $type
     */
    public function removeType(\Core\TypeBundle\Entity\Type $type);
    
    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTypes();
    
    /**
     * @param \Exam\CoreBundle\Entity\ExamInterface $exam
     */
    public function setExam(\Exam\CoreBundle\Entity\ExamInterface $exam = null);
    
    /**
     * @return \Exam\CoreBundle\Entity\ExamInterface
     */
    public function getExam();
    
    /**
     * @param \Exam\CoreBundle\Entity\CriteriaQuestionInterface $criteriaQuestion
     */
    public function setCriteriaQuestion(\Exam\CoreBundle\Entity\CriteriaQuestionInterface $criteriaQuestion = null);
    
    /**
     * @return \Exam\CoreBundle\Entity\CriteriaQuestionInterface
     */
    public function getCriteriaQuestion();
    
    /**
     * @param \Exam\CoreBundle\Entity\CriteriaQuestionInterface $criteriaQuestion
     */
    public function addCriteriaQuestion(\Exam\CoreBundle\Entity\CriteriaQuestionInterface $criteriaQuestion);
    
    /**
     * @param \Exam\CoreBundle\Entity\CriteriaQuestionInterface $criteriaQuestion
     */
    public function removeCriteriaQuestion(\Exam\CoreBundle\Entity\CriteriaQuestionInterface $criteriaQuestion);
    
    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getCriteriaQuestions();
}
