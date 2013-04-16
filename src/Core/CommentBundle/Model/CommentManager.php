<?php

/*
 * This file is part of the CoreCommentBundle package.
 *
 * 2013 (c) Testyrskills.com <http://www.Testyrskills.com/>
 *
 */

namespace Core\CommentBundle\Model;

/**
 * Abstract Comment Manager implementation which can be used as base class for your
 * concrete manager.
 *
 * @author David Maignan <davidmaignan@gmail.com>
 */
abstract class CommentManager
{

    /**
     * Constructor.
     *
     */
    public function __construct()
    {
        
    }

    /**
     * Returns an empty comment instance
     *
     * @return CommentInterface
     */
    public function createComment()
    {
        $class = $this->getClass();
        $comment = new $class;
        
        return $comment;
    }
    

    /**
     * {@inheritDoc}
     */
    public function supportsClass($class)
    {
        return $class === $this->getClass();
    }
}
