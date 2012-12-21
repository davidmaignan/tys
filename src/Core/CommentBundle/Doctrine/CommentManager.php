<?php

/*
 * This file is part of the QuestionCreateBundle package.
 *
 * (c) Testyrskills.com <http://www.Testyrskills.com/>
 *
 */

namespace Core\CommentBundle\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;
use FOS\UserBundle\Model\UserInterface;
use Core\CommentBundle\Model\CommentManager as BaseCommentManager;
use FOS\UserBundle\Util\CanonicalizerInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class CommentManager extends BaseCommentManager
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
    public function deleteComment(CommentInterface $question)
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
     * @param LevelInterface $user
     * @param Boolean       $andFlush Whether to flush the changes (default true)
     * 
     */
     
    public function updateComment($comment, $andFlush = true)
    {

        $this->objectManager->persist($comment);
        if ($andFlush) {
            $this->objectManager->flush();
        }
    }
     
}
