<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Exam\CoreBundle\Doctrine;

/**
 * Description of CriteriaQuestionManager
 *
 * @author davidmaignan
 */

use Doctrine\Common\Persistence\ObjectManager;
use Exam\CoreBundle\Model\CriteriaQuestionManager as BaseCriteriaQuestionManager;
use Exam\CoreBundle\Model\CriteriaQuestionMangagerInterface;
use Exam\CoreBundle\Entity\CriteriaQuestionInterface;

class CriteriaQuestionManager extends BaseCriteriaQuestionManager
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
    public function deleteCriteriaQuestion(CriteriaQuestionInterface $criteriaQuestion)
    {
        $this->objectManager->remove($criteriaQuestion);
        $this->objectManager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function findCriteriaQuestionBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }
    
    /**
     * Updates an crieria question entity.
     *
     * @param CriteriaQuestionInterface $criteriaQuestion
     * @param Boolean                   $andFlush Whether to flush the changes (default true)
     * 
     */
    public function updateCriteriaQuestion(CriteriaQuestionInterface $criteriaQuestion, $andFlush = true)
    {
        $this->objectManager->persist($criteriaQuestion);
        if ($andFlush) {
            $this->objectManager->flush();
        }
    }
}
