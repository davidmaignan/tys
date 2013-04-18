<?php

/*
 * This file is part of the QuestionCreateBundle package.
 *
 * (c) Testyrskills.com <http://www.Testyrskills.com/>
 *
 */

namespace Question\CreateBundle\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;
use FOS\UserBundle\Model\UserInterface;
use Question\CreateBundle\Model\QuestionManager as BaseQuestionManager;
use FOS\UserBundle\Util\CanonicalizerInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Core\QuestionBundle\Entity\QuestionInterface;

class QuestionManager extends BaseQuestionManager
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
    public function deleteQuestion(QuestionInterface $question)
    {
        $this->objectManager->remove($question);
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
     * Updates a question.
     *
     * @param QuestionInterface $question
     * @param Boolean       $andFlush Whether to flush the changes (default true)
     * 
     */
    public function updateQuestion(QuestionInterface $question, $andFlush = true)
    {

        $this->objectManager->persist($question);
        if ($andFlush) {
            $this->objectManager->flush();
        }
    }
     
}
