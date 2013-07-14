<?php

/*
 * This file is part of the SectionCreateBundle package.
 *
 * (c) Testyrskills.com <http://www.Testyrskills.com/>
 *
 */

namespace Core\SectionBundle\Doctrine;

/**
 * Interface to be implemented by section manager. This adds an additional level
 * of abstraction between the application, and the actual repository.
 *
 * @author David Maignan <davidmaignan@gmail.com>
 */

use Doctrine\Common\Persistence\ObjectManager;
use Core\SectionBundle\Entity\SectionInterface;

interface SectionManagerInterface
{
    /**
     * Creates an empty section instance.
     *
     * @return UserInterface
     */
    public function createSection();
    
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
     * Delete a section
     * 
     * @param Core\SectionBundle\Entity\SectionInterface $section
     */
    public function deleteSection(SectionInterface $section);

    /**
     * Finds one section by the given criteria.
     *
     * @param array $criteria
     *
     * @return Core\SectionBundle\Entity\SectionInterface
     */
    public function findSectionBy(array $criteria);

    /**
     * Returns a collection with all section instances.
     *
     * @return \Traversable
     */
    public function findSections();

    /**
     * Returns the section's fully qualified class name.
     *
     * @return string
     */
    public function getClass();

    /**
     * Updates a section.
     *
     * @param Core\SectionBundle\Entity\SectionInterface $section
     * @param Boolean                                    $andFlush Whether to flush the changes (default true)
     * 
     */
    public function updateSection(SectionInterface $section, $andFlush = true);

}
