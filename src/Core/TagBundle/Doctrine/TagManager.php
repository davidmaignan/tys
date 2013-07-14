<?php

/*
 * This file is part of the TagCreateBundle package.
 *
 * (c) Testyrskills.com <http://www.Testyrskills.com/>
 *
 */

namespace Core\TagBundle\Doctrine;

/**
 * @author David Maignan <davidmaignan@gmail.com>
 */

use Doctrine\Common\Persistence\ObjectManager;
use Core\TagBundle\Model\TagManager as BaseTagManager;
use Core\TagBundle\Entity\TagInterface;

class TagManager extends BaseTagManager implements TagManagerInterface
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
    public function deleteTag(TagInterface $tag)
    {
        $this->objectManager->remove($tag);
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
    public function findTagBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }
    
    /**
     * {@inheritDoc}
     */
    public function findTagsByName(array $criteria)
    {
        return $this->repository->getTagsByName($criteria)->getResult();
    }

    /**
     * {@inheritDoc}
     */
    public function findTags()
    {
        return $this->repository->findAll();
    }

    /**
     * Updates a tag.
     *
     * @param TagInterface $tag
     * @param Boolean      $andFlush Whether to flush the changes (default true)
     * 
     */
    public function updateTag(TagInterface $tag, $andFlush = true)
    {

        $this->objectManager->persist($tag);
        if ($andFlush) {
            $this->objectManager->flush();
        }
    }
     
}
