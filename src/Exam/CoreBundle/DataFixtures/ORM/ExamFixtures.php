<?php

namespace Exam\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Collections\ArrayCollection;

use Exam\CoreBundle\Entity\Exam;
use Exam\CoreBundle\Entity\ExamCriteria;

class ExamFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    
    public function load(ObjectManager $manager)
    {
        //Exam
        $exam = new Exam();
        
        $exam->setOwner($manager->merge($this->getReference('user-2')));
        $exam->addCandidate($manager->merge($this->getReference('user-2')));
        
        $examCriteria = new ExamCriteria();
        $examCriteria->setLevel($manager->merge($this->getReference('level-2')));
        $examCriteria->setNumberCandidates(5);
        $examCriteria->setNumberQuestions(50);
        $examCriteria->addSection($manager->merge($this->getReference('section-1')));
        $examCriteria->addSection($manager->merge($this->getReference('section-2')));
        $examCriteria->addSection($manager->merge($this->getReference('section-3')));
           
        $examCriteria->addTag($manager->merge($this->getReference('tag-1')));
        $examCriteria->addTag($manager->merge($this->getReference('tag-2')));
        $examCriteria->addTag($manager->merge($this->getReference('tag-3')));
        $examCriteria->addTag($manager->merge($this->getReference('tag-4')));
        $examCriteria->addTag($manager->merge($this->getReference('tag-5')));
        $examCriteria->addTag($manager->merge($this->getReference('tag-6')));
        $examCriteria->addTag($manager->merge($this->getReference('tag-7')));
        $examCriteria->addTag($manager->merge($this->getReference('tag-8')));
        
        $exam->setExamCriteria($examCriteria);
        
        
        $manager->persist($exam);
        
        $this->addReference('exam-1', $exam);

        $manager->flush();

    }
    
    
    /**
     * Get the order of this fixture
     * 
     * @return integer
     */  
    function getOrder(){
        return 7; // the order in which fixtures will be loaded
    }
}
