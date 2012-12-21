<?php
/**
 * @copyright 2012 Testyrskills.com
 */

namespace Core\QuestionBundle\Entity;

/**
 * QueueStatus Entity
 *
 * @author Paul Munson <pmunson@nationalfibre.net>
 */
class QuestionStatus
{
    /**
     * Initial question status
     */
    const INITIAL  = 0;

    /**
     * QUestion status is set to "PENDING" before reviewer start to review it
     */
    const PENDING  = 1;
    
    /**
     * QUestion status is set to "REVIEW" once reviewer start to review it
     */
    const REVIEW  = 2;
    
    /**
     * QUestion status is set to "FEEDBACK" if reviewer request some modification to owner
     */
    const FEEDBACK  = 3;
    
    /**
     * Question is approved
     */
    const APPROVED = 4;

    /**
     * Question is rejected
     */
    const REJECTED = 5;

    /**
     * Question is archived
     */
    const ARCHIVED = 6;
}