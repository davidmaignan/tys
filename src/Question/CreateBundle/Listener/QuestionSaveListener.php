<?php

namespace Question\CreateBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Core\QuestionBundle\Entity\Question;


class QuestionSaveListener
{
    protected $mailer;
    private $status;
    
    public function __construct($mailer)
    {
        $this->mailer = $mailer;
    }
    
    /*
    public function preUpdate(LifecycleEventArgs $args)
    {
        echo 'preUpdate';
        
        $entity = $args->getEntity();
        $entitiesChanged = $args->getEntityChangeSet();
        
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        // Question entity
        if ($entity instanceof Question && array_key_exists('status', $entitiesChanged)) {
            $this->status = $entitiesChanged['status'];
        }
    }
     * 
     */
    
    public function postUpdate(LifecycleEventArgs $args)
    {
        
        //echo 'status has changed';
        //var_dump($this->status);
        //exit;
        
        if(is_int($this->status)){
            
         
        
         switch($status[1]){
                
                case 1: //pending
                    $this->mailer->sendQuestionEmailSubmission($entity, $entity->getUser());
                    break;
                case 2: //review
                    //$this->mailer->sendQuestionEmailSubmission($entity);
                    break;
                case 3: //feedback
                    //$this->mailer->sendQuestionFeedbackEmail($entity);
                    break;
                case 4: //approved
                    //$this->mailer->sendQuestionApprovedEmail($entity);
                    break;
                case 5: //rejected
                    //$this->mailer->sendQuestionRejectedEmail($entity);
                    break;
                case 6: //archived
                    //$this->mailer->sendQuestionArchivedEmail($entity);
                    break;   
            }
        
        }
        
    }
    
    public function onFlush(OnFlushEventArgs $eventArgs)
    {
        $em = $eventArgs->getEntityManager();
        $uow = $em->getUnitOfWork();

      
        foreach ($uow->getScheduledEntityUpdates() AS $entity) {
            
            //var_dump(get_class($entity));
            
            //echo 'onFlush';
            //exit;
        }

    }
    
   
}
