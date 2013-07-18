<?php

/**
 * @copyright 2013 testyrskills.com
 */
namespace Exam\CoreBundle\Entity;

/**
 * ExamCandidate class
 *
 * @author David Maignan <davidmaignan@gmail.com>
 */

use Doctrine\ORM\Mapping as ORM;

/**
 * Exam\CoreBundle\Entity\ExamCandidate
 *
 * @ORM\Table(name="exam_candidate")
 * @ORM\Entity(repositoryClass="Exam\CoreBundle\Entity\ExamCandidate")
 * @ORM\HasLifecycleCallbacks()
 */
class ExamCandidate {
    
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Exam\CoreBundle\Entity\Exam", inversedBy="examCandidates")
     */
    private $exam;
    
    /**
     * @ORM\ManyToOne(targetEntity="\Security\AuthenticateBundle\Entity\User", inversedBy="examCandidates")
     */
    private $candidate;
    
    /**
     * @var integer $completion
     *
     * @ORM\Column(name="completion", type="integer", nullable=true)
     */
    private $completion;
    
    /**
     * @ORM\OneToMany(targetEntity="Core\QuestionBundle\Entity\Question", mappedBy="ExamCandidate")
     */
    private $questionsAnswered;
    
    /**
     * @var datetime $updatedAt
     * @ORM\Column(name="updatedAt", type="datetime") 
     */
    private $startedAt;
    
    /**
     * @var boolean $completed
     * 
     * @ORM\Column(name="completed", type="boolean", nullable=false)
     *
     */
    private $completed = false;
    
    public function __construct()
    {
        $this->questionsAnswered = new \Doctrine\Common\Collections\ArrayCollection();
    }
}

?>
