<?php
/**
 * @copyright 2013 testyrskills Inc.
 */

namespace Exam\ManageBundle\Form\Service;

use Exam\ManageBundle\Form\Model\ExamInvitationFormModel;
use Exam\CoreBundle\Entity\ExamCandidate;


/**
 * Exam Invitation Form Service
 */
class ExamInvitationFormService
{
    
    /**
     * @var \Symfony\Component\HttpFoundation\Session\Session
     */
    private $session;
    
    /**
     * @var \Mailer\MailBundle\Mailer\Mailer
     */
    private $mailer;
    
    /**
     * @var \Exam\CoreBundle\Doctrine\ExamManager
     */
    private $examManager;
    
    /**
     * @var \Exam\CoreBundle\Doctrine\ExamCandidateManager
     */
    private $examCandidateManager;
    
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
    public function __construct($session, $mailer, $examManager, $examCandidateManager, $userManager){
        
        $this->session              = $session;
        $this->mailer               = $mailer;
        $this->examManager          = $examManager;
        $this->examCandidateManager = $examCandidateManager;
        $this->userManager          = $userManager;
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
            $this->session->setFlash('exam_candidate_error', 'No exam exists');
            return false;
        }
        
        //Already exists
        $examCandidate = $this->examCandidateManager->findExamCandidateBy(array(
            'candidate' => $user,
            'exam'      => $exam
        ));
        
        if($examCandidate){
            $this->session->setFlash('exam_candidate_error', 'This candidate is already registered for this exam');
            return false;
        }
        
        $examCandidate = $this->examCandidateManager->createExamCandidate();
        $examCandidate->setCandidate($user);
        $examCandidate->setExam($exam);
        $exam->addExamCandidate($examCandidate);
        $this->examManager->updateExam($exam);
        
        $mailer = $this->mailer->sendExamInvitation($exam, $user);
        
        return true;
    }
}
