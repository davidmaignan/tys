<?php

namespace Core\LevelBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Core\LevelBundle\Entity\Level;

class LevelFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    
    public function load(ObjectManager $manager)
    {
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
        
        $manager->flush();

    }
    
    
    /**
     * Get the order of this fixture
     * 
     * @return integer
     */  
    function getOrder(){
        return 2; // the order in which fixtures will be loaded
    }
}
