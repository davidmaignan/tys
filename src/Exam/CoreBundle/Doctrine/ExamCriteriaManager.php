<?php

/*
 * This file is part of the QuestionCreateBundle package.
 *
 * (c) Testyrskills.com <http://www.Testyrskills.com/>
 *
 */

namespace Exam\CoreBundle\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;
use FOS\UserBundle\Model\UserInterface;
use Exam\CoreBundle\Model\ExamCriteriaManager as BaseExamCriteriaManager;
use Exam\CoreBundle\Entity\ExamCriteriaInterface;

class ExamCriteriaManager extends BaseExamCriteriaManager
{
    protected $objectManager;
    protected $class;
    protected $repository;

    /**
     * Constructor.
     *
     * @param ObjectManager           $om
     * @param string                  $class
     */
    public function __construct(ObjectManager $om, $class)
    {
        parent::__construct();

        $this->objectManager = $om;
        $this->repository = $om->getRepository($class);

        $metadata = $om->getClassMetadata($class);
        $this->class = $metadata->getName();
    }

    /**
     * {@inheritDoc}
     */
    public function deleteExamCriteria(ExamCriteriaInterface $examCriteria)
    {
        $this->objectManager->remove($examCriteria);
        $this->objectManager->flush();
    }
    
    /**
     * {@inheritDoc}
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * {@inheritDoc}
     */
    public function findQuestionBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }

    /**
     * {@inheritDoc}
     */
    public function findQuestions()
    {
        return $this->repository->findAll();
    }

   
    /**
     * Updates an examcriteria.
     *
     * @param ExamCriteriaInterface $examCriteria
     * @param Boolean       $andFlush Whether to flush the changes (default true)
     * 
     */
     
    public function updateExamCriteria(ExamCriteriaInterface $examCriteria, $andFlush = true)
    {

        $this->objectManager->persist($examCriteria);
        if ($andFlush) {
            $this->objectManager->flush();
        }
    }
     
}
