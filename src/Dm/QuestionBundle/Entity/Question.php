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
 * @ORM\HasLifecycleCallbacks()
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
     * @ORM\OneToMany(targetEntity="answer", mappedBy="question", cascade={"persist, remove"},  orphanRemoval=false)
     */
    public $answers;
    
    
    /**
     * @var datetime $createdAt
     * @ORM\Column(name="createdAt", type="datetime") 
     */
    private $createdAt;
    
    /**
     * @var datetime $updatedAt
     * @ORM\Column(name="updatedAt", type="datetime") 
     */
    private $updatedAt;

    public function __construct() {
        $this->tags = new ArrayCollection();
        $this->answers = new ArrayCollection();
        
        $this->setCreatedAt(new \DateTime());
        $this->setUpdatedAt(new \DateTime());
    }

    public function __toString() {
        return $this->getTitle();
    }

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
    public function addTag(Tag $tags) {
        $this->tags[] = $tags;
        return $this;
    }

    /**
     * Remove tags
     *
     * @param <variableType$tags
     */
    public function removeTag(Tag $tags) {
        $this->tags->removeElement($tags);
    }

    /**
     * Get tags
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTags() {
        return $this->tags;
    }


    /**
     * Add answers
     *
     * @param Dm\QuestionBundle\Entity\answer $answers
     * @return Question
     */
    public function addAnswer(\Dm\QuestionBundle\Entity\answer $answers)
    {
        $this->answers[] = $answers;
        return $this;
    }

    /**
     * Remove answers
     *
     * @param <variableType$answers
     */
    public function removeAnswer(\Dm\QuestionBundle\Entity\answer $answers)
    {
        $this->answers->removeElement($answers);
    }

    /**
     * Get answers
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getAnswers()
    {
        return $this->answers;
    }
    
    
    /**
     * @ORM\preUpdate
     */
    public function setUpdatedAtValue()
    {
       $this->setUpdatedAt(new \DateTime());
    }

    /**
     * Set createdAt
     *
     * @param datetime $createdAt
     * @return Question
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return datetime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param datetime $updatedAt
     * @return Question
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return datetime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}