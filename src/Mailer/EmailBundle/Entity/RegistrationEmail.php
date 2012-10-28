<?php

namespace Mailer\EmailBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint as UniqueConstraint;
use Mailer\EmailBundle\Entity\Email;


/**
 * Mailer\EmailBundle\Entity\Registration
 * @ORM\Entity
 * @ORM\Table(name="registration")
 */
class RegistrationEmail extends Email implements EmailInterface
{
    
    /**
     * @var string activationkey 
     * 
     * @ORM\Column(name="activationkey", type="string", length=100)
     */
    private $activationkey;
    
    /**
     * Set activationkey
     *
     * @param string $activationkey
     * @return Registration
     */
    public function setActivationkey($activationkey)
    {
        $this->activationkey = $activationkey;
    
        return $this;
    }

    /**
     * Get activationkey
     *
     * @return string 
     */
    public function getActivationkey()
    {
        return $this->activationkey;
    }
    
}