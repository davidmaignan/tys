<?php

namespace Blogger\BlogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Dm\QuestionBundle\Entity\Section;
use Dm\QuestionBundle\Entity\Level;
use Dm\QuestionBundle\Entity\Tag;

class GeneralFixtures  extends AbstractFixture implements OrderedFixtureInterface
{
    
    public function load(ObjectManager $manager)
    {
        //Section
        $section1 = new Section();
        $section1->setName('PHP');
        $manager->persist($section1);
        
        $section2 = new Section();
        $section2->setName('Java');
        $manager->persist($section2);
        
        $section3 = new Section();
        $section3->setName('C++');
        $manager->persist($section3);
        
        $this->addReference('section-1', $section1);
        $this->addReference('section-2', $section2);
        $this->addReference('section-3', $section3);
        
        
        //Level
        $level1 = new Level();
        $level1->setName('Beginner');
        $manager->persist($level1);
        
        $level2 = new Level();
        $level2->setName('Intermediate');
        $manager->persist($level2);
        
        $level3 = new Level();
        $level3->setName('Advanced');
        $manager->persist($level3);
        
        $level4 = new Level();
        $level4->setName('Expert');
        $manager->persist($level4);
        
        $this->addReference('level-1', $level1);
        $this->addReference('level-2', $level2);
        $this->addReference('level-3', $level3);
        $this->addReference('level-4', $level4);
        
        //Tag
        $tags = array(1=>'core','variables','type casting/juggling','operators','strings','arrays','object/class',
                        'design patterns', 'file system', 'namespace', 'PDO', 'configuration', 'session', 'regex',
                        'predefined variables', 'php.ini', 'output control', 'error handling', 'control structures',
                        'cookie', 'functions');
        
        $tagsObject = array();
        
        foreach($tags as $key=>$tag){
            
            $$tag = new Tag();
            $$tag->setName($tag);
            $manager->persist($$tag);
            $this->addReference('tag-'.$key, $$tag);
        }
        
        
    
    
    
   
        
        $manager->flush();
        
        
        
    }
    
     public function getOrder()
    {
        return 1; // the order in which fixtures will be loaded
    }
    
}
