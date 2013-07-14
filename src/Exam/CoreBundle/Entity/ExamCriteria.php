<?php

namespace Exam\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\Validator\Mapping\ClassMetadata;// for overriding function loadValidatorMetadata()
use Symfony\Component\Validator\Constraints\NotBlank;// for notblank constrain
use Symfony\Component\Validator\Constraints\Email;//for email constrain
use Symfony\Component\Validator\Constraints\MinLength;// for minimum length
use Symfony\Component\Validator\Constraints\MaxLength; // for maximum length
use Symfony\Component\Validator\Constraints\Choice; // for choice fields
use Symfony\Component\Validator\Constraints\Regex; // for regular expression


/**
 * Exam\CoreBundle\Entity\ExamCriteria
 *
 * @ORM\Table(name="exam_criteria")
 * @ORM\Entity(repositoryClass="Exam\CoreBundle\Entity\ExamCriteria")
 * @ORM\HasLifecycleCallbacks()
 */
class ExamCriteria implements ExamCriteriaInterface
{
        /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    
    /**  The owning side has 'inversedBy'. Its table will have
     *   the foreign key.
     * @ORM\OneToOne(targetEntity="Exam\CoreBundle\Entity\Exam", inversedBy="examCriteria", cascade={"persist"})
     * @ORM\JoinColumn(name="exam_id", referencedColumnName="id")
     */
     private $exam;
    
    /**
     * @ORM\ManyToMany(targetEntity="Core\SectionBundle\Entity\Section", inversedBy="examCriterias")
     * @ORM\JoinTable(name="exam_criteria_sections")
     * @Assert\Count(
     *      min = "1",
     *      minMessage = "You must choose at least one test"
     * )
     */
    private $sections;
    
    /**
     * @var text $numberCandidates
     *
     * @ORM\Column(name="number_candidate", type="integer")
     * 
     * @Assert\NotBlank(message = "You must select a number of questions")
     */
    private $numberCandidates;
    
    
    /**
     * @ORM\ManyToOne(targetEntity="Core\LevelBundle\Entity\Level")
     * @ORM\JoinColumn(name="level_id", referencedColumnName="id")
     * @Assert\NotBlank(message = "You must select a level for this test")
     */
    private $level;
    
    /**
     * @var text $numberQuestions
     *
     * @ORM\Column(name="number_questions", type="integer")
     * 
     * @Assert\NotBlank(message = "You must select a number of questions")
     */
    private $numberQuestions;
    
    
    /**
     * @ORM\ManyToMany(targetEntity="Core\TypeBundle\Entity\Type")
     * @ORM\JoinTable(name="exam_criteria_types")
     * @Assert\Count(
     *      min = "1",
     *      minMessage = "You must choose at least one type of question"
     * )
     */
    private $types;  
    
    /**
     * @ORM\ManyToMany(targetEntity="Core\TagBundle\Entity\Tag", inversedBy="examCriterias")
     * @ORM\JoinTable(name="exam_criteria_tags")
     * @Assert\Count(
     *      min = "5",
     *      minMessage = " |You must select at least %count% topics"
     * )
     */
    private $tags;
    
    /**
     * @ORM\OneToOne(targetEntity="ExamQuestion", mappedBy="examCriteria")
     */
    private $examQuestion;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->sections = new \Doctrine\Common\Collections\ArrayCollection();
        $this->types = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
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
     * Set numberCandidates
     *
     * @param integer $numberCandidates
     * @return ExamCriteria
     */
    public function setNumberCandidates($numberCandidates)
    {
        $this->numberCandidates = $numberCandidates;
    
        return $this;
    }

    /**
     * Get numberCandidates
     *
     * @return integer 
     */
    public function getNumberCandidates()
    {
        return $this->numberCandidates;
    }

    /**
     * Set numberQuestions
     *
     * @param integer $numberQuestions
     * @return ExamCriteria
     */
    public function setNumberQuestions($numberQuestions)
    {
        $this->numberQuestions = $numberQuestions;
    
        return $this;
    }

    /**
     * Get numberQuestions
     *
     * @return integer 
     */
    public function getNumberQuestions()
    {
        return $this->numberQuestions;
    }

    

    /**
     * Set level
     *
     * @param Core\LevelBundle\Entity\Level $level
     * @return ExamCriteria
     */
    public function setLevel(\Core\LevelBundle\Entity\Level $level = null)
    {
        $this->level = $level;
    
        return $this;
    }

    /**
     * Get level
     *
     * @return Core\LevelBundle\Entity\Level 
     */
    public function getLevel()
    {
        return $this->level;
    }


    /**
     * Add tags
     *
     * @param Core\TagBundle\Entity\Tag $tags
     * @return ExamCriteria
     */
    public function addTag(\Core\TagBundle\Entity\Tag $tags)
    {
        $this->tags[] = $tags;
    
        return $this;
    }

    /**
     * Remove tags
     *
     * @param Core\TagBundle\Entity\Tag $tags
     */
    public function removeTag(\Core\TagBundle\Entity\Tag $tags)
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
    
    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $sections
     */
    public function setSections(ArrayCollection $sections)
    {
        $this->sections = $sections;
    }

    /**
     * Add sections
     *
     * @param Core\SectionBundle\Entity\Section $sections
     * @return ExamCriteria
     */
    public function addSection(\Core\SectionBundle\Entity\Section $sections)
    {
        $this->sections[] = $sections;
    
        return $this;
    }

    /**
     * Remove sections
     *
     * @param Core\SectionBundle\Entity\Section $sections
     */
    public function removeSection(\Core\SectionBundle\Entity\Section $sections)
    {
        $this->sections->removeElement($sections);
    }

    /**
     * Get sections
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getSections()
    {
        return $this->sections;
    }

    /**
     * Add types
     *
     * @param Core\TypeBundle\Entity\Type $types
     * @return ExamCriteria
     */
    public function addType(\Core\TypeBundle\Entity\Type $types)
    {
        $this->types[] = $types;
    
        return $this;
    }

    /**
     * Remove types
     *
     * @param Core\TypeBundle\Entity\Type $types
     */
    public function removeType(\Core\TypeBundle\Entity\Type $types)
    {
        $this->types->removeElement($types);
    }

    /**
     * Get types
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTypes()
    {
        return $this->types;
    }

    /**
     * Set exam
     *
     * @param Exam\CoreBundle\Entity\Exam $exam
     * @return ExamCriteria
     */
    public function setExam(\Exam\CoreBundle\Entity\Exam $exam = null)
    {
        $this->exam = $exam;
    
        return $this;
    }

    /**
     * Get exam
     *
     * @return Exam\CoreBundle\Entity\Exam 
     */
    public function getExam()
    {
        return $this->exam;
    }

    /**
     * Set examQuestion
     *
     * @param \Exam\CoreBundle\Entity\ExamQuestion $examQuestion
     * @return ExamCriteria
     */
    public function setExamQuestion(\Exam\CoreBundle\Entity\ExamQuestion $examQuestion = null)
    {
        $this->examQuestion = $examQuestion;

        return $this;
    }

    /**
     * Get examQuestion
     *
     * @return \Exam\CoreBundle\Entity\ExamQuestion 
     */
    public function getExamQuestion()
    {
        return $this->examQuestion;
    }
}
