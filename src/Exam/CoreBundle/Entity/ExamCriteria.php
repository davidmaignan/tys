<?php

namespace Exam\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\Validator\Constraints as Assert;


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
     * @ORM\OneToMany(targetEntity="CriteriaQuestion", mappedBy="examCriteria")
     */
    private $criteriaQuestions;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->sections         = new \Doctrine\Common\Collections\ArrayCollection();
        $this->types            = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tags             = new \Doctrine\Common\Collections\ArrayCollection();
        $this->criteriaQuestion = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @param Core\LevelBundle\Entity\LevelInterface $level
     * @return ExamCriteria
     */
    public function setLevel(\Core\LevelBundle\Entity\LevelInterface $level = null)
    {
        $this->level = $level;
    
        return $this;
    }

    /**
     * Get level
     *
     * @return Core\LevelBundle\Entity\LevelInterface 
     */
    public function getLevel()
    {
        return $this->level;
    }


    /**
     * Add tags
     *
     * @param Core\TagBundle\Entity\TagInterface $tag
     * @return ExamCriteria
     */
    public function addTag(\Core\TagBundle\Entity\TagInterface $tag)
    {
        $this->tags[] = $tag;
    
        return $this;
    }

    /**
     * Remove tags
     *
     * @param Core\TagBundle\Entity\Tag $tag
     */
    public function removeTag(\Core\TagBundle\Entity\Tag $tag)
    {
        $this->tags->removeElement($tag);
    }

    /**
     * Get tags
     *
     * @return Doctrine\Common\Collections\ArrayCollection 
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Add sections
     *
     * @param Core\SectionBundle\Entity\Section $section
     * @return ExamCriteria
     */
    public function addSection(\Core\SectionBundle\Entity\Section $section)
    {
        $this->sections[] = $section;
    
        return $this;
    }

    /**
     * Remove sections
     *
     * @param Core\SectionBundle\Entity\Section $section
     */
    public function removeSection(\Core\SectionBundle\Entity\Section $section)
    {
        $this->sections->removeElement($section);
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
     * @param Core\TypeBundle\Entity\Type $type
     * @return ExamCriteria
     */
    public function addType(\Core\TypeBundle\Entity\Type $type)
    {
        $this->types[] = $type;
    
        return $this;
    }

    /**
     * Remove types
     *
     * @param Core\TypeBundle\Entity\Type $type
     */
    public function removeType(\Core\TypeBundle\Entity\Type $type)
    {
        $this->types->removeElement($type);
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
     * @param Exam\CoreBundle\Entity\ExamInterface $exam
     * @return ExamCriteria
     */
    public function setExam(\Exam\CoreBundle\Entity\ExamInterface $exam = null)
    {
        $this->exam = $exam;
    
        return $this;
    }

    /**
     * Get exam
     *
     * @return Exam\CoreBundle\Entity\ExamInterface
     */
    public function getExam()
    {
        return $this->exam;
    }

    /**
     * Set criteriaQuestion
     *
     * @param \Exam\CoreBundle\Entity\CriteriaQuestionInterface $examQuestion
     * @return CriteriaQuestion
     */
    public function setCriteriaQuestion(\Exam\CoreBundle\Entity\CriteriaQuestionInterface $criteriaQuestion = null)
    {
        $this->criteriaQuestion = $criteriaQuestion;

        return $this;
    }

    /**
     * Get criteriaQuestion
     *
     * @return \Exam\CoreBundle\Entity\CriteriaQuestion 
     */
    public function getCriteriaQuestion()
    {
        return $this->criteriaQuestion;
    }

    /**
     * Add criteriaQuestions
     *
     * @param \Exam\CoreBundle\Entity\CriteriaQuestionInterface $criteriaQuestion
     * @return ExamCriteria
     */
    public function addCriteriaQuestion(\Exam\CoreBundle\Entity\CriteriaQuestionInterface $criteriaQuestion)
    {
        $this->criteriaQuestions[] = $criteriaQuestion;

        return $this;
    }

    /**
     * Remove criteriaQuestions
     *
     * @param \Exam\CoreBundle\Entity\CriteriaQuestionInterface $criteriaQuestion
     */
    public function removeCriteriaQuestion(\Exam\CoreBundle\Entity\CriteriaQuestionInterface $criteriaQuestion)
    {
        $this->criteriaQuestions->removeElement($criteriaQuestion);
    }

    /**
     * Get criteriaQuestions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCriteriaQuestions()
    {
        return $this->criteriaQuestions;
    }
}
