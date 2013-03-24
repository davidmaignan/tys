<?php
// src/Api/OauthBundle/Entity/Client.php

namespace Api\OauthBundle\Entity;

use FOS\OAuthServerBundle\Entity\Client as BaseClient;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Client extends BaseClient
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var text $name
     *
     * @ORM\Column(name="name", type="text")
     * 
     */
    protected $name;
    
    public function __construct()
    {
        parent::__construct();
    }
    
    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }    
}