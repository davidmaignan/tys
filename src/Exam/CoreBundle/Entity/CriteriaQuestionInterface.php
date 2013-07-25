<?php
/**
 * This file is part of the ExamCoreBundle package.
 *
 * (c) Testyrskills.com <http://www.Testyrskills.com/>
 *
 */

namespace Exam\CoreBundle\Entity;

/**
 * @author David Maignan <davidmaignan@gmail.com>
 */

interface CriteriaQuestionInterface {
    /**
     * @param Exam\CoreBundle\Entity\ExamCriteria
     */
    public function setExamCriteria(\Exam\CoreBundle\Entity\ExamCriteria $examCriteria = null);
    
    /**
     * @return \Exam\CoreBundle\Enityt\ExamCriteriaInterface
     */
    public function getExamCriteria();
    
    /**
     * @param \Core\QuestionBundle\Entity\QuestionInterface
     */
    public function addQuestion(\Core\QuestionBundle\Entity\QuestionInterface $question);
    
    /**
     * @param \Core\QuestionBundle\Entity\QuestionInterface
     */
    public function removeQuestion(\Core\QuestionBundle\Entity\QuestionInterface $question);
    
    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getQuestions();
}