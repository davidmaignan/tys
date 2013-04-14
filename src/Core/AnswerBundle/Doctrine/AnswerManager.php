<?php

/*
 * This file is part of the CoreAnswerBundle package.
 *
 * (c) Testyrskills.com <http://www.Testyrskills.com/>
 *
 */

namespace Core\AnswerBundle\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;
use Core\AnswerBundle\Model\AnswerManager as BaseAnswerManager;

class AnswerManager extends BaseAnswerManager
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
    public function deleteAnswer(AnswerInterface $answer)
    {
        $this->objectManager->remove($answer);
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
    public function findAnswerBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }

    /**
     * {@inheritDoc}
     */
    public function findAnswers()
    {
        return $this->repository->findAll();
    }

    /**
     * Updates an answer
     *
     * @param AnswerInterface $answer
     * @param Boolean         $andFlush Whether to flush the changes (default true)
     * 
     */
    public function updateAnswer(AnswerInterface $answer, $andFlush = true)
    {

        $this->objectManager->persist($answer);
        if ($andFlush) {
            $this->objectManager->flush();
        }
    }
     
}
