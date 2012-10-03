<?php

namespace Core\AnswerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\MinLength;
use Symfony\Component\Validator\Constraints\MaxLength;

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
     *  @var text $title
     * 
     *  @ORM\Column(name="title", type="text") 
     */
    private $title;
    
    
    /**
    * @ORM\ManyToOne(targetEntity="question", inversedBy="answers", cascade={"persist"})
    * @ORM\JoinColumn(name="question_id", referencedColumnName="id", onDelete="CASCADE")
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
     * @param Dm\QuestionBundle\Entity\question $question
     * @return Answer
     */
    public function setQuestion(\Core\QuestionBundle\Entity\question $question = null)
    {
        $this->question = $question;
        return $this;
    }

    /**
     * Get question
     *
     * @return Core\QuestionBundle\Entity\question 
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

}