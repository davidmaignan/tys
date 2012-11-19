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
     * QUestion status is set to "PENDING" once reviewer start to review it
     */
    const PENDING  = 1;

    /**
     * Question is approved
     */
    const APPROVED = 2;

    /**
     * Question is rejected
     */
    const REJECTED = 3;

    /**
     * Question is archived
     */
    const ARCHIVED = 4;
}