<?php

namespace Core\SectionBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Core\SectionBundle\Entity\Section;

class SectionFixtures extends AbstractFixture implements OrderedFixtureInterface
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
        
        $section4 = new Section();
        $section4->setName('Javascript');
        $manager->persist($section4);
        
        $section5 = new Section();
        $section5->setName('Ruby');
        $manager->persist($section5);
        
        $section6 = new Section();
        $section6->setName('Python');
        $manager->persist($section6);
        
        $this->addReference('section-1', $section1);
        $this->addReference('section-2', $section2);
        $this->addReference('section-3', $section3);
        $this->addReference('section-4', $section4);
        $this->addReference('section-5', $section5);
        $this->addReference('section-6', $section6);
        
        $manager->flush();
    }
    
    
    /**
     * Get the order of this fixture
     * 
     * @return integer
     */  
    function getOrder(){
        return 1; // the order in which fixtures will be loaded
    }
}
