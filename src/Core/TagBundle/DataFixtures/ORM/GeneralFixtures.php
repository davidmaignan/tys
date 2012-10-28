<?php

namespace Core\TagBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;


use Core\TagBundle\Entity\Tag;


class GeneralFixtures  extends AbstractFixture implements OrderedFixtureInterface
{
    
    public function load(ObjectManager $manager)
    {
        
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
        return 4; // the order in which fixtures will be loaded
    }
    
}
