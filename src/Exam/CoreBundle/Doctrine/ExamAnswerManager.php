<?php

/*
 * This file is part of the QuestionCreateBundle package.
 *
 * (c) Testyrskills.com <http://www.Testyrskills.com/>
 *
 */

namespace Exam\CoreBundle\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;
use Exam\CoreBundle\Model\ExamAnswerManager as BaseExamAnswerManager;
use Exam\CoreBundle\Model\ExamAnswerManagerInterface;
use Exam\CoreBundle\Entity\ExamAnswerInterface;


class ExamAnswerManager extends BaseExamAnswerManager
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
    public function deleteExamANswer(ExamAnswerInterface $exam)
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
    public function findExamAnswerBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }

    /**
     * {@inheritDoc}
     */
    public function findExamAnswers(\Security\AuthenticateBundle\Entity\User $owner)
    {
        return $this->repository->findBy(array('owner'=>$owner));
    }
    
    
    /**
     * Updates an examcriteria.
     *
     * @param ExamAnswerInterface $examAnswer
     * @param Boolean             $andFlush Whether to flush the changes (default true)
     * 
     */
    public function updateExamAnswer(ExamAnswerInterface $examAnswer, $andFlush = true)
    {

        $this->objectManager->persist($examAnswer);
        if ($andFlush) {
            $this->objectManager->flush();
        }
    }
     
}
