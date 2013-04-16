<?php

/*
 * This file is part of the CoreCommentBundle package.
 *
 * 2013 (c) Testyrskills.com <http://www.Testyrskills.com/>
 *
 */

namespace Core\CommentBundle\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;
use Core\CommentBundle\Model\CommentManager as BaseCommentManager;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Core\CommentBundle\Entity\CommentInterface;

class CommentManager extends BaseCommentManager implements CommentManagerInterface
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
    public function getClass()
    {
        return $this->class;
    }

    /**
     * {@inheritDoc}
     */
    public function findCommentBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }

    /**
     * {@inheritDoc}
     */
    public function findComments()
    {
        return $this->repository->findAll();
    }
   
    /**
     * Updates a user.
     *
     * @param Core\CommentBundle\Entity\CommentInterface $user
     * @param Boolean                                    $andFlush Whether to flush the changes (default true)
     * 
     */
    public function updateComment(CommentInterface $comment, $andFlush = true)
    {

        $this->objectManager->persist($comment);
        if ($andFlush) {
            $this->objectManager->flush();
        }
    }
    
    /**
     * {@inheritDoc}
     */
    public function deleteComment(CommentInterface $comment)
    {
        $this->objectManager->remove($comment);
        $this->objectManager->flush();
    }
}
