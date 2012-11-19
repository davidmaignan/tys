<?php

namespace Question\CreateBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Core\QuestionBundle\Entity\Question;
use Core\AnswerBundle\Entity\Answer;

class QuestionFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    
    public function load(ObjectManager $manager)
    {
        
        $question1 = new Question();
        $question1->setTitle('Test');
        $question1->setPoints(1);
        $question1->setSection($manager->merge($this->getReference('section-1')));
        $question1->setLevel($manager->merge($this->getReference('level-'.rand(1,4))));
        $question1->getTags()->add($manager->merge($this->getReference('tag-21')));
        $question1->setType($manager->merge($this->getReference('type')));
        $question1->setUser($manager->merge($this->getReference('user-1')));
        $manager->persist($question1);
        
        $answers = array("Test");
        $correct = 0;
        
        foreach($answers as $key=>$value){
            $answer = new Answer();
            $answer->setTitle($value);
            $question1->getAnswers()->add($answer);
            $answer->setQuestion($question1);
            $answer->setCorrect(($correct === $key));
            $manager->persist($answer);
        }
         
        $manager->flush();

    }
    
    public function getOrder()
    {
        return 6; // the order in which fixtures will be loaded
    }
    
}