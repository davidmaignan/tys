<?php

/*
 * This file is part of the QuestionCreateBundle package.
 *
 * (c) Testyrskills.com <http://www.Testyrskills.com/>
 *
 */

namespace Exam\CoreBundle\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;
use Exam\CoreBundle\Model\ExamManager as BaseExamManager;
use Exam\CoreBundle\Model\ExamManagerInterface;
use Exam\CoreBundle\Entity\ExamInterface;

class ExamManager extends BaseExamManager
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
    public function deleteExam(ExamInterface $exam)
    {
        $this->objectManager->remove($exam);
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
    public function findExamBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }

    /**
     * {@inheritDoc}
     */
    public function findExams()
    {
        return $this->repository->findAll();
    }

   
    /**
     * Updates an examcriteria.
     *
     * @param ExamInterface $exam
     * @param Boolean       $andFlush Whether to flush the changes (default true)
     * 
     */
    public function updateExam(ExamInterface $exam, $andFlush = true)
    {

        $this->objectManager->persist($exam);
        if ($andFlush) {
            $this->objectManager->flush();
        }
    }
     
}
