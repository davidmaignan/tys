<?php

/*
 * This file is part of the CoreAnswerBundle package.
 *
 * 2013 (c) Testyrskills.com <http://www.testyrskills.com/>
 *
 */

namespace Core\LevelBundle\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;
use Core\LevelBundle\Model\LevelManager as BaseLevelManager;
use Core\LevelBundle\Entity\LevelInterface;

/**
 * Level Manager
 *
 * @author David Maignan <davidmaignan@gmail.com>
 */

class LevelManager extends BaseLevelManager implements LevelManagerInterface
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
    public function deleteLevel(LevelInterface $level)
    {
        $this->objectManager->remove($level);
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
    public function findLevelBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }

    /**
     * {@inheritDoc}
     */
    public function findLevels()
    {
        return $this->repository->findAll();
    }
   
    /**
     * Updates a user.
     *
     * @param LevelInterface $user
     * @param Boolean       $andFlush Whether to flush the changes (default true)
     * 
     */
    public function updateLevel(LevelInterface $level, $andFlush = true)
    {
        $this->objectManager->persist($level);
        if ($andFlush) {
            $this->objectManager->flush();
        }
    }
     
}
