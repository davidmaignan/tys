<?php

namespace Core\TypeBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Core\TypeBundle\Entity\Type;

class TypeFixtures  extends AbstractFixture implements OrderedFixtureInterface
{
    
    public function load(ObjectManager $manager)
    {     
        
        $type = new Type();
        $type->setName('single');
        $manager->persist($type);
        $this->addReference('type', $type);
        
        $type = new Type();
        $type->setName('multiple');
        $manager->persist($type);
        
        $type = new Type();
        $type->setName('coding');
        $manager->persist($type);
    
        $manager->flush();
        
    }
    
    public function getOrder()
    {
        return 3; // the order in which fixtures will be loaded
    }
    
}
