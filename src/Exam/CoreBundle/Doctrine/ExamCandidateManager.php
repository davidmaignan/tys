<?php

/*
 * This file is part of the QuestionCreateBundle package.
 *
 * (c) Testyrskills.com <http://www.Testyrskills.com/>
 *
 */

namespace Exam\CoreBundle\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;
use Exam\CoreBundle\Model\ExamCandidateManager as BaseExamCandidateManager;
use Exam\CoreBundle\Entity\ExamCandidateInterface;


class ExamCandidateManager extends BaseExamCandidateManager {
    
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
    public function findExamCandidateBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }
    
    /**
     * Updates an examCandidate.
     *
     * @param ExamCandidateInterface $examCandidate
     * @param Boolean                $andFlush Whether to flush the changes (default true)
     * 
     */
    public function updateExamCandidate(ExamCandidateInterface $examCandidate, $andFlush = true)
    {

        $this->objectManager->persist($examCandidate);
        if ($andFlush) {
            $this->objectManager->flush();
        }
    }
}

