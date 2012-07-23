<?php

namespace Dm\QuestionBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Dm\QuestionBundle\Entity\Question;
use Dm\QuestionBundle\Entity\Answer;

class QuestionFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    
    public function load(ObjectManager $manager)
    {
        
        $question1 = new Question();
        $question1->setTitle('What is the result of calling json_encode() on an empty array?');
        $question1->setPoints(1);
        $question1->setSection($manager->merge($this->getReference('section-1')));
        $question1->setLevel($manager->merge($this->getReference('level-1')));
        $question1->getTags()->add($manager->merge($this->getReference('tag-1')));
        $manager->persist($question1);
        
        $answers = array("'' - An empty JavaScript string", "{} - An empty JavaScript object", "[] - An empty JavaScript array",
                         "undefined");
        
        
        foreach($answers as $value){
            $answer = new Answer();
            $answer->setTitle($value);
            $question1->getAnswers()->add($answer);
            $answer->setQuestion($question1);
            $answer->setCorrect(false);
            $manager->persist($answer);
        }
        
        
        
        $question2 = new Question();
        $question2->setTitle('Replace the ... by the right answer in the following PHP code : chmod ( $filename , ... );');
        $question2->setPoints(1);
        $question2->setSection($manager->merge($this->getReference('section-1')));
        $question2->setLevel($manager->merge($this->getReference('level-1')));
        $question2->getTags()->add($manager->merge($this->getReference('tag-1')));
        $manager->persist($question2);
        
        $answers2 = array("'0755'", "0755", "0x755", "755");
        
        
        foreach($answers2 as $value){
            $answer = new Answer();
            $answer->setTitle($value);
            $question2->getAnswers()->add($answer);
            $answer->setQuestion($question2);
            $answer->setCorrect(false);
            $manager->persist($answer);
        }
        
        
        
        $manager->flush();
    }
    
    public function getOrder()
    {
        return 2; // the order in which fixtures will be loaded
    }
    
}