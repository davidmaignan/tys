<?php

/*
 * This file is part of the ExamGenerateBundle package.
 *
 * 2013 (c) Testyrskills.com <http://www.testyrskills.com/>
 *
 */

namespace Exam\GenerateBundle\Context;

use Symfony\Component\HttpKernel\KernelInterface;
use Behat\MinkExtension\Context\MinkContext;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Gherkin\Node\TableNode;
use Behat\Symfony2Extension\Context\KernelAwareInterface;
use Behat\Behat\Exception\PendingException;

use Exam\CoreBundle\Entity\ExamCriteria;
use Exam\CoreBundle\Entity\Exam;
use Exam\CoreBundle\Entity\ExamQuestion;

//
// Require 3rd-party libraries here:
//
require_once 'PHPUnit/Autoload.php';
require_once 'PHPUnit/Framework/Assert/Functions.php';

/**
 * Context to generate exams
 *
 * @author David Maignan <davidmaignan@gmail.com>
 */

class GenerateContext extends RawMinkContext implements KernelAwareInterface
{
    /**
     * @var KernelInterface Kernel
     */
    private $kernel;

    /**
     * @var array
     */
    private $dictionary = array();

    /**
     * {@inheritdoc}
     */
    public function setKernel(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }
    
    /**
     * Get service from container
     *
     * @param string $serviceName Service name
     *
     * @return mixed
     */
    private function getService($serviceName)
    {
        return $this->kernel->getContainer()->get($serviceName);
    }
    
    /**
     * Create exam(s) from a table.  
     *
     * Example:
     *   Given the following exam exist:
     *     | language | number_candidates | level | number_questions | type | tags |
     * 
     * @Given /^the following exam exists:$/
     */
    public function theFollowingExamExists(TableNode $table)
    {
        $hash = $table->getHash();
        
        $examCriteria = new ExamCriteria();
        $exam         = new Exam();
        
        $sectionManager = $this->getService('section_manager');
        $levelManager   = $this->getService('level_manager');
        $userManager    = $this->getService('fos_user.user_manager');
        $tagManager     = $this->getService('tag_manager');
        
        foreach ($hash as $row) {
            
            $section   = $sectionManager->findSectionBy(array('name'=>$row['language']));
            $level     = $levelManager->findLevelBy(array('name'=>$row['level']));
            $owner     = $userManager->findUserBy(array('username'=>$row['owner']));
            $candidate = $userManager->findUserBy(array('username'=>$row['candidate']));
            $tags      = $tagManager->findTagsByName(explode(',', $row['tags']));
            
            $examCriteria->addSection($section);
            $examCriteria->setLevel($level);
            $examCriteria->setNumberCandidates($row['number_candidates']);
            $examCriteria->setNumberQuestions($row['number_questions']);
            
            foreach($tags as $tag)
            {
                $examCriteria->addTag($tag);
                $tag->addExamCriteria($examCriteria);
            }
            
            $exam->setOwner($owner);
            $exam->addCandidate($candidate);
            $exam->setExamCriteria($examCriteria);  
            $examCriteria->setExam($exam);
        }
        
        $em = $this->getService('doctrine')->getManager();
        
       
        // Exam Manager
        $questions = $em->getRepository('CoreQuestionBundle:Question')->findAll();
        
        $listQuestionsKeys = array_rand($questions, 10);
        
        $examQuestion = new ExamQuestion();
        $examQuestion->setExamCriteria($examCriteria);
        
        foreach ($listQuestionsKeys as $value) {
            $examQuestion->addQuestion($questions[$value]);
            
            $questions[$value]->addExamQuestion($examQuestion);
            $em->persist($questions[$value]);
        }
          
        $em->persist($exam);
        $em->persist($examCriteria);
        $em->persist($examQuestion);
        $em->flush();
        
    }
    
}