<?php

namespace Mailer\EmailBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint as UniqueConstraint;
use Mailer\EmailBundle\Entity\Email;

use Exam\CoreBundle\Entity\Exam;
use Security\AuthenticateBundle\Entity\User;


/**
 * Mailer\EmailBundle\Entity\SendInvitationEmail
 * @ORM\Entity
 * @ORM\Table(name="send_invitation")
 */
class SendInvitationEmail extends Email implements EmailInterface
{
    
    /**
     * @ORM\OneToOne(targetEntity="Exam\CoreBundle\Entity\Exam")
     * @ORM\JoinColumn(name="exam_id", referencedColumnName="id")
     */
    private $exam;
    
    /**
     * @ORM\OneToOne(targetEntity="Security\AuthenticateBundle\Entity\User")
     * @ORM\JoinColumn(name="candidate_id", referencedColumnName="id")
     */
    private $candidate;
    
    /**
     * Set question
     *
     * @param Exam\CoreBundle\Entity\Exam $exam
     * @return SendInvitationEmail
     */
    public function setExam(Exam $exam = null)
    {
        $this->exam = $exam;
    
        return $this;
    }

    /**
     * Get question
     *
     * @return Exam\CoreBundle\Entity\Exam
     */
    public function getExam()
    {
        return $this->exam;
    }

    /**
     * Set candidate
     *
     * @param \Security\AuthenticateBundle\Entity\User $candidate
     * @return SendInvitationEmail
     */
    public function setCandidate(\Security\AuthenticateBundle\Entity\User $candidate = null)
    {
        $this->candidate = $candidate;
    
        return $this;
    }

    /**
     * Get candidate
     *
     * @return \Security\AuthenticateBundle\Entity\User 
     */
    public function getCandidate()
    {
        return $this->candidate;
    }
}