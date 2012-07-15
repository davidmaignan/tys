<?php

namespace Dm\QuestionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Dm\QuestionBundle\Entity\Question
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Dm\QuestionBundle\Entity\QuestionRepository")
 */
class Question {

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
     */
    private $title;

    /**
     * @var text $code
     *
     * @ORM\Column(name="code", type="text")
     */
    private $code;

    /**
     * @var text $note
     *
     * @ORM\Column(name="note", type="text")
     */
    private $note;

    /**
     * @var integer $section
     *
     * @ORM\Column(name="section", type="integer")
     */
    private $section;

    /**
     * @var integer $level
     *
     * @ORM\Column(name="level", type="integer")
     */
    private $level;

    /**
     * @var integer $type
     *
     * @ORM\Column(name="type", type="integer")
     */
    private $type;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param text $title
     * @return Question
     */
    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    /**
     * Get title
     *
     * @return text 
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Set code
     *
     * @param text $code
     * @return Question
     */
    public function setCode($code) {
        $this->code = $code;
        return $this;
    }

    /**
     * Get code
     *
     * @return text 
     */
    public function getCode() {
        return $this->code;
    }

    /**
     * Set note
     *
     * @param text $note
     * @return Question
     */
    public function setNote($note) {
        $this->note = $note;
        return $this;
    }

    /**
     * Get note
     *
     * @return text 
     */
    public function getNote() {
        return $this->note;
    }

    /**
     * Set section
     *
     * @param integer $section
     * @return Question
     */
    public function setSection($section) {
        $this->section = $section;
        return $this;
    }

    /**
     * Get section
     *
     * @return integer 
     */
    public function getSection() {
        return $this->section;
    }

    /**
     * Set level
     *
     * @param integer $level
     * @return Question
     */
    public function setLevel($level) {
        $this->level = $level;
        return $this;
    }

    /**
     * Get level
     *
     * @return integer 
     */
    public function getLevel() {
        return $this->level;
    }

    /**
     * Set type
     *
     * @param integer $type
     * @return Question
     */
    public function setType($type) {
        $this->type = $type;
        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType() {
        return $this->type;
    }
    

    public function __toString() {
        return $this->getTitle();
    }

}