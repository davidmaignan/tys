<?php

/*
 * This file is part of the TagCreateBundle package.
 *
 * (c) Testyrskills.com <http://www.Testyrskills.com/>
 *
 */

namespace Core\TagBundle\Doctrine;

/**
 * Interface to be implemented by tag manager. This adds an additional level
 * of abstraction between the application, and the actual repository.
 *
 * @author David Maignan <davidmaignan@gmail.com>
 */

use Doctrine\Common\Persistence\ObjectManager;
use Core\TagBundle\Entity\TagInterface;

interface TagManagerInterface
{
    /**
     * Creates an empty tag instance.
     *
     * @return UserInterface
     */
    public function createTag();
    
    /**
     * 
     * @param type $class
     */
    public function supportsClass($class);
    
    /**
     * 
     * @param Doctrine\Common\Persistence\ObjectManager $om
     * @param type                                      $class
     */
    public function __construct(ObjectManager $om, $class);
    
    /**
     * Delete a tag
     * 
     * @param Core\TagBundle\Entity\TagInterface $tag
     */
    public function deleteTag(TagInterface $tag);

    /**
     * Finds one tag by the given criteria.
     *
     * @param array $criteria
     *
     * @return Core\TagBundle\Entity\TagInterface
     */
    public function findTagBy(array $criteria);

    /**
     * Returns a collection with all tag instances.
     *
     * @return \Traversable
     */
    public function findTags();

    /**
     * Returns the tag's fully qualified class name.
     *
     * @return string
     */
    public function getClass();

    /**
     * Updates a tag.
     *
     * @param Core\TagBundle\Entity\TagInterface $tag
     * @param Boolean                            $andFlush Whether to flush the changes (default true)
     * 
     */
    public function updateTag(TagInterface $tag, $andFlush = true);
}
