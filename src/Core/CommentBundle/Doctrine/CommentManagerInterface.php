<?php

/*
 * This file is part of the CoreCommentBundle package.
 *
 * 2013 (c) Testyrskills.com <http://www.Testyrskills.com/>
 *
 */

namespace Core\CommentBundle\Doctrine;

use Core\CommentBundle\Entity\CommentInterface;

/**
 * Interface to be implemented by comment manager. This adds an additional level
 * of abstraction between your application, and the actual repository.
 *
 * @author David Maignan <davidmaignan@gmail.com>
 */
interface CommentManagerInterface
{
    /**
     * Returns the comment's fully qualified class name.
     *
     * @return string
     */
    public function getClass();
    
    /**
     * {@inheritDoc}
     */
    public function supportsClass($class);
    
    /**
     * Creates an empty question instance.
     *
     * @return Core\CommentBundle\Entity\CommentInterface
     */
    public function createComment();
    
    /**
     * Deletes a commetn.
     *
     * @param Core\CommentBundle\Entity\CommentInterface $comment
     *
     * @return void
     */
    public function deleteComment(CommentInterface $comment);

    /**
     * Finds one comment by the given criteria.
     *
     * @param array $criteria
     *
     * @return Core\CommentBundle\Entity\CommentInterface
     */
    public function findCommentBy(array $criteria);

    /**
     * Returns a collection with all comment instances.
     *
     * @return \Traversable
     */
    public function findComments();

    /**
     * Updates a user.
     *
     * @param Core\CommentBundle\Entity\CommentInterface $comment
     *
     * @return void
     */
    public function updateComment(CommentInterface $user);

}
