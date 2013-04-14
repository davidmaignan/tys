<?php

namespace Exam\PracticeBundle\Form\Model;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

class ExamAnswerFormModel {
    
    
    /**
     * @ORM\OneToOne(targetEntity="Exam\CoreBundle\Entity\ExamAnswer", mappedBy="examAnswer", cascade={"persist"} )
     */
    private $examAnswer;
    
    /**
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $answer;
    
    
    public function setExamAnswer($examAnswer) {
        $this->examAnswer = $examAnswer;
        
        return $this;
    }
    
    public function getExamAnswer() {
        return $this->examAnswer;
    }
    
    public function setAnswer($answer) {
        $this->answer = $answer;
        
        return $this;
    }
    
    public function getAnswer(){
        return $this->answer;
    }
}
