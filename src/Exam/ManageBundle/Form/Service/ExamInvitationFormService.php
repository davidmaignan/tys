<?php
/**
 * @copyright 2013 testyrskills Inc.
 */

namespace Exam\ManageBundle\Form\Service;

use Exam\ManageBundle\Form\Model\ExamInvitationFormModel;


/**
 * Exam Invitation Form Service
 */
class ExamInvitationFormService
{
    
    /**
     * @var \Mailer\MailBundle\Mailer\Mailer
     */
    private $mailer;
    
    /**
     * @var \Exam\CoreBundle\Doctrine\ExamManager
     */
    private $examManager;
    
    /**
     * @var \FOS\UserBundle\Doctrine\UserManager
     */
    private $userManager;
    
    /**
     * Constructor
     * @param type $mailer
     * @param type $examManager
     * @param type $userManager 
     */
    public function __construct($mailer, $examManager, $userManager){
        
        $this->mailer      = $mailer;
        $this->examManager = $examManager;
        $this->userManager = $userManager;
    }
    
    /**
     * Execute service
     * @param ExamInvitationFormModel $examInvitationFormModel
     * @return boolean 
     */
    public function execute(ExamInvitationFormModel $examInvitationFormModel){
        
        $email = $examInvitationFormModel->getEmail();
        $user  = $this->userManager->findUserBy(array('email'=>$email));
        
        if(!$user){
            $user = $this->userManager->createUser();
            $user->setUsername(strtolower($examInvitationFormModel->getFirstName().$examInvitationFormModel->getLastName()));
            $user->setPlainPassword('password');
            $user->setEmail($email);
            $this->userManager->updateUser($user);
        }
        
        $exam = $this->examManager->findExamBy(array('id'=>$examInvitationFormModel->getExamId()));
        
        if(!$exam){
            return false;
        }
        
        $exam = new \Exam\CoreBundle\Entity\Exam();
        $exam->addCandidate($user);
        $this->examManager->updateExam($exam);
        
        $mailer = $this->mailer->sendExamInvitation($exam, $user);
        
        return true;
        
    }
}
