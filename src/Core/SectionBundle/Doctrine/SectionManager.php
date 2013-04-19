<?php

/*
 * This file is part of the SectionCreateBundle package.
 *
 * (c) Testyrskills.com <http://www.Testyrskills.com/>
 *
 */

namespace Core\SectionBundle\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;

use Core\SectionBundle\Model\SectionManager as BaseSectionManager;

use Core\SectionBundle\Entity\SectionInterface;

class SectionManager extends BaseSectionManager implements SectionManagerInterface
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
    public function deleteSection(SectionInterface $section)
    {
        $this->objectManager->remove($section);
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
    public function findSectionBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }

    /**
     * {@inheritDoc}
     */
    public function findSections()
    {
        return $this->repository->findAll();
    }

    /**
     * Updates a section.
     *
     * @param SectionInterface $section
     * @param Boolean       $andFlush Whether to flush the changes (default true)
     * 
     */
    public function updateSection(SectionInterface $section, $andFlush = true)
    {

        $this->objectManager->persist($section);
        if ($andFlush) {
            $this->objectManager->flush();
        }
    }
     
}
