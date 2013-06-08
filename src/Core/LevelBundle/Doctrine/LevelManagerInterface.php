<?php

/*
 * This file is part of the CoreAnswerBundle package.
 *
 * 2013 (c) Testyrskills.com <http://www.testyrskills.com/>
 *
 */

namespace Core\LevelBundle\Doctrine;

use Core\LevelBundle\Entity\LevelInterface;

/**
 * Level Manager Interface
 * 
 * All changes to levels should happen through this interface.
 *
 * @author David Maignan <davidmaignan@gmail.com>
 */

interface LevelManagerInterface
{
    /**
     * Creates an empty level instance.
     *
     * @return Core\LevelBundle\Entity\LevelInterface
     */
    public function createLevel();
    
    /**
     * @param string $class
     */
    public function supportsClass($class);
    
    /**
     * Returns the level's fully qualified class name.
     *
     * @return string
     */
    public function getClass();

    /**
     * Deletes a level.
     *
     * @param Core\LevelBundle\Entity\LevelInterface $level
     *
     * @return void
     */
    public function deleteLevel(LevelInterface $level);

    /**
     * Finds one level by the given criteria.
     *
     * @param array $criteria
     *
     * @return Core\LevelBundle\Entity\LevelInterface
     */
    public function findLevelBy(array $criteria);

    /**
     * Returns a collection with all levels instances.
     *
     * @return \Traversable
     */
    public function findLevels();
}
