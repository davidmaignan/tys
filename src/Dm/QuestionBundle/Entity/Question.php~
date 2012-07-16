<?php

namespace Dm\QuestionBundle\Entity;

use Dm\QuestionBundle\Entity\Tag;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Dm\QuestionBundle\Entity\Question
 *
 * @ORM\Table(name="question")
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
     * @ORM\Column(name="code", type="text", nullable=true)
     */
    private $code;

    /**
     * @var text $note
     *
     * @ORM\Column(name="note", type="text", nullable=true)
     */
    private $note;

    /**
     * @ORM\ManyToOne(targetEntity="Section", inversedBy="questions")
     * @ORM\JoinColumn(name="section_id", referencedColumnName="id")
     */
    protected $section;

    /**
     * @ORM\ManyToOne(targetEntity="Level", inversedBy="questions")
     * @ORM\JoinColumn(name="level_id", referencedColumnName="id")
     */
    private $level;

    /**
     * @ORM\ManyToOne(targetEntity="Type", inversedBy="questions")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     */
    private $type;

    /**
     * @var integer $points
     *
     * @ORM\Column(name="points", type="integer")
     */
    private $points;

    /**
     * @ORM\ManyToMany(targetEntity="Tag", inversedBy="Questions")
     * @ORM\JoinTable(name="question_tags")
     */
    private $tags;

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

    public function __construct() {
        $this->tags = new ArrayCollection();
    }

    public function __toString() {
        return $this->getTitle();
    }

    /**
     * Set points
     *
     * @param integer $points
     * @return Question
     */
    public function setPoints($points) {
        $this->points = $points;
        return $this;
    }

    /**
     * Get points
     *
     * @return integer 
     */
    public function getPoints() {
        return $this->points;
    }


    /**
     * Add tags
     *
     * @param Dm\QuestionBundle\Entity\Tag $tags
     * @return Question
     */
    public function addTag(Tag $tags)
    {
        $this->tags[] = $tags;
        return $this;
    }

    /**
     * Remove tags
     *
     * @param <variableType$tags
     */
    public function removeTag(Tag $tags)
    {
        $this->tags->removeElement($tags);
    }

    /**
     * Get tags
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTags()
    {
        return $this->tags;
    }
}