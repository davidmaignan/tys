<?php

namespace Core\AnswerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\MinLength;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Core\QuestionBundle\Entity\Question;

/**
 * @ORM\Entity 
 * @ORM\Table(name="answer")
 */
class Answer
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @var text $title
     * 
     * @ORM\Column(name="title", type="text") 
     * @Assert\NotBlank(groups={"Approval"})
     */
    private $title;
    
            
    /**
    * @ORM\ManyToOne(targetEntity="Core\QuestionBundle\Entity\Question", inversedBy="answers")
    * @ORM\JoinColumn(name="question_id", referencedColumnName="id",
                onDelete="CASCADE")
    */
    private $question;
    
    
    /**
     * @var text $code 
     * @ORM\Column(name="code", type="text", nullable=true)
     */
    private $code;
    
    
    /**
     * @var text $note
     * @ORM\Column(name="note", type="text", nullable=true) 
     */
    private $note;
    
    
    
    /**
     * @var boolean $correct
     * @ORM\Column(name="correct", type="boolean") 
     */
    private $correct;
    

    

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param text $title
     * @return Answer
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Get title
     *
     * @return text 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set question
     *
     * @param Core\QuestionBundle\Entity\Question $question
     * @return Answer
     */
    public function setQuestion(Question $question = null)
    {
        $this->question = $question;
        return $this;
    }

    /**
     * Get question
     *
     * @return Core\QuestionBundle\Entity\Question 
     */
    public function getQuestion()
    {
        return $this->question;
    }
    
    /**
     * Set code
     *
     * @param text $code
     * @return Answer
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * Get code
     *
     * @return text 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set note
     *
     * @param text $note
     * @return Answer
     */
    public function setNote($note)
    {
        $this->note = $note;
        return $this;
    }

    /**
     * Get note
     *
     * @return text 
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set correct
     *
     * @param boolean $correct
     * @return Answer
     */
    public function setCorrect($correct)
    {
        $this->correct = $correct;
        return $this;
    }

    /**
     * Get correct
     *
     * @return boolean 
     */
    public function getCorrect()
    {
        return $this->correct;
    }
    
    public function __toString()
    {
        return 'answer';
    }
    
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('title', new NotBlank());

        
    }

}
