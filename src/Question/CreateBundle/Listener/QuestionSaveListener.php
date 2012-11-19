<?php

namespace Question\CreateBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\ContainerInterface;


class QuestionSaveListener
{
    protected $mailer;
    
    public function __construct($mailer)
    {
        $this->mailer = $mailer;
    }
    
    public function postPersist(LifecycleEventArgs $args)
    {
        //var_dump($this->mailer);
        //$this->mailer->
        //exit;
    }
}
