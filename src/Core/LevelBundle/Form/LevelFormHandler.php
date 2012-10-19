<?php

namespace Core\LevelBundle\Form;

///use FOS\UserBundle\Model\UserManagerInterface;
//use FOS\UserBundle\Model\UserInterface;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class LevelFormHandler
{
    
    protected $request;
    protected $form;
    protected $levelManager;
    
    public function __construct(FormInterface $form, Request $request, $levelManager)
    {
        $this->form = $form;
        $this->request = $request;
        $this->levelManager = $levelManager;      
    }
    
    public function process($confirmation = false)
    {
        
        $level = $this->createLevel();  
        
        $this->form->setData($level);
        
        if ('POST' === $this->request->getMethod()) {

            $this->form->bind($this->request);
            
            if ($this->form->isValid()) {
                $this->onSuccess($level, $confirmation);
                return true;
            }
        }

        return false;
        
    }
    
    /**
     * @param boolean $confirmation
     */
    protected function onSuccess($level, $confirmation)
    {
        if ($confirmation) {
            
            $this->mailer->sendConfirmationEmailMessage($level);
        } else {
            //$level->setEnabled(true);
        }

        $this->levelManager->updateLevel($level);
    }
    
     /**
     * @return UserInterface
     */
    protected function createLevel()
    {
        return $this->levelManager->createLevel();
    }
}
