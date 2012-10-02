<?php

namespace Mailer\MailBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mailer\MailBundle\Entity\Mailer
 *
 * @ORM\Table(name="mailer")
 * @ORM\Entity(repositoryClass="Mailer\MailBundle\Entity\MailerRepository")
 */
class Mailer
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     *  Constructor
     */
    public function __construct()
    {
        
    }
    
    public function __toString()
    {
        return __CLASS__;
    }
}
