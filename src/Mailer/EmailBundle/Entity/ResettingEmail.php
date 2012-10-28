<?php

namespace Mailer\EmailBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint as UniqueConstraint;
use Mailer\EmailBundle\Entity\Email;


/**
 * Mailer\EmailBundle\Entity\Resetting
 * @ORM\Entity
 * @ORM\Table(name="resetting")
 */
class ResettingEmail extends Email implements EmailInterface
{
    
    
    
}