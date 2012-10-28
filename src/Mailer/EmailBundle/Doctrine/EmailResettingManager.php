<?php

/*
 * This file is part of the MailerEmailBundle package.
 *
 * (c) Testyrskills.com <http://www.Testyrskills.com/>
 *
 */

namespace Mailer\EmailBundle\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;
use Mailer\EmailBundle\Model\EmailResettingManager as BaseEmailResettingManager;
use Mailer\EmailBundle\Entity\EmailInterface;
use Mailer\MailBundle\Event\EmailEventInterface;


class EmailResettingManager extends BaseEmailResettingManager
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
     * Updates email.
     *
     * @param EmailInterface $email
     * @param Boolean       $andFlush Whether to flush the changes (default true)
     * 
     */
    public function updateEmail(EmailInterface $email, $andFlush = true)
    {

        $this->objectManager->persist($email);
        if ($andFlush) {
            $this->objectManager->flush();
        }
    }
    
    /**
     * Bind event parameters to email
     * @param EmailInterface $email
     * @param EmailEventInterface $event 
     */
    public function bind(EmailInterface $email, EmailEventInterface $event)
    {
        parent::bind($email, $event);
        
    }
    
}

