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
        $question1->getTags()->add($manager->merge($this->getReference('tag-21')));
        $manager->persist($question1);
        
        $answers = array("'' - An empty JavaScript string", "{} - An empty JavaScript object", "[] - An empty JavaScript array",
                         "undefined");
        $correct = 1;
        
        foreach($answers as $key=>$value){
            $answer = new Answer();
            $answer->setTitle($value);
            $question1->getAnswers()->add($answer);
            $answer->setQuestion($question1);
            $answer->setCorrect(($correct === $key));
            $manager->persist($answer);
        }
        
        
        
        $question2 = new Question();
        $question2->setTitle('Replace the ... by the right answer in the following PHP code : chmod ( $filename , ... );');
        $question2->setPoints(1);
        $question2->setSection($manager->merge($this->getReference('section-1')));
        $question2->setLevel($manager->merge($this->getReference('level-1')));
        $question2->getTags()->add($manager->merge($this->getReference('tag-9')));
        $manager->persist($question2);
        
        $answers2 = array("'0755'", "0755", "0x755", "755");
        $correct = 1;
        
        foreach($answers2 as $key=>$value){
            $answer = new Answer();
            $answer->setTitle($value);
            $question2->getAnswers()->add($answer);
            $answer->setQuestion($question2);
            $answer->setCorrect(($correct === $key));
            $manager->persist($answer);
        }
        
        $question3 = new Question();
        $question3->setTitle('Which PHP function would you use to get current session information about cookies?');
        $question3->setPoints(1);
        $question3->setSection($manager->merge($this->getReference('section-1')));
        $question3->setLevel($manager->merge($this->getReference('level-1')));
        $question3->getTags()->add($manager->merge($this->getReference('tag-20')));
        $manager->persist($question3);
        
        $answers3 = array("set_cookie()", "get_cookie()", "session_get_cookie_params()", "session_set_cookie_params()");
        $correct = 2;
        
        foreach($answers3 as $key=>$value){
            $answer = new Answer();
            $answer->setTitle($value);
            $question3->getAnswers()->add($answer);
            $answer->setQuestion($question3);
            $answer->setCorrect(($correct === $key));
            $manager->persist($answer);
        }
        
        $question4 = new Question();
        $question4->setTitle('Which one below can NOT be caught with a custom error handler?');
        $question4->setPoints(1);
        $question4->setSection($manager->merge($this->getReference('section-1')));
        $question4->setLevel($manager->merge($this->getReference('level-1')));
        $question4->getTags()->add($manager->merge($this->getReference('tag-18')));
        $manager->persist($question4);
        
        $answers4 = array("E_NOTICE", "E_ERROR", "E_USER_ERROR", "E_WARNING","E_RECOVERABLE_ERROR");
        
        $correct = 1;
        
        foreach($answers4 as $key=>$value){
            $answer = new Answer();
            $answer->setTitle($value);
            $question4->getAnswers()->add($answer);
            $answer->setQuestion($question4);
            $answer->setCorrect(($correct === $key));
            $manager->persist($answer);
        }
        
        $question5 = new Question();
        $question5->setTitle('is_a( $a, $b ) will:');
        $question5->setPoints(1);
        $question5->setSection($manager->merge($this->getReference('section-1')));
        $question5->setLevel($manager->merge($this->getReference('level-1')));
        $question5->getTags()->add($manager->merge($this->getReference('tag-7')));
        $manager->persist($question5);
        
        $answers5 = array("it is not a built-in php function", "check if \$a is of class '\$b' or has this class as one of 
            its parents", "Check if \$a is of type \"\$b\"");
        
        $correct = 1;
        
        foreach($answers5 as $key=>$value){
            $answer = new Answer();
            $answer->setTitle($value);
            $question5->getAnswers()->add($answer);
            $answer->setQuestion($question5);
            $answer->setCorrect(($correct === $key));
            $manager->persist($answer);
        }
        
        
        $question6 = new Question();
        $question6->setTitle('Given an array of images, $images = array("img12.png", "img10.png", "img2.png", "img1.png"), which function will sort $images into ("img1.png", "img2.png", "img10.png", "img12.png")?');
        $question6->setPoints(1);
        $question6->setSection($manager->merge($this->getReference('section-1')));
        $question6->setLevel($manager->merge($this->getReference('level-1')));
        $question6->getTags()->add($manager->merge($this->getReference('tag-6')));
        $manager->persist($question6);
        
        $answers6 = array("ksort(\$images);", "asort(\$images);", "natsort(\$images);", "usort(\$images);","arsort(\$images);");
        
        $correct = 2;
        
        foreach($answers6 as $key=>$value){
            $answer = new Answer();
            $answer->setTitle($value);
            $question5->getAnswers()->add($answer);
            $answer->setQuestion($question6);
            $answer->setCorrect(($correct === $key));
            $manager->persist($answer);
        }
        
        $question6 = new Question();
        $question6->setTitle('Which function would you use to obtain the ASCII value of a character?');
        $question6->setPoints(1);
        $question6->setSection($manager->merge($this->getReference('section-1')));
        $question6->setLevel($manager->merge($this->getReference('level-1')));
        $question6->getTags()->add($manager->merge($this->getReference('tag-5')));
        $manager->persist($question6);
        
        $answers6 = array("asc( );", "ord( );", "chr( );", "val( );");
        
        $correct = 1;
        
        foreach($answers6 as $key=>$value){
            $answer = new Answer();
            $answer->setTitle($value);
            $question5->getAnswers()->add($answer);
            $answer->setQuestion($question6);
            $answer->setCorrect(($correct === $key));
            $manager->persist($answer);
        }
        
        $question6 = new Question();
        $question6->setTitle('Which type specifier is invalid when used within the format string argument of a printf( ) statement?');
        $question6->setPoints(1);
        $question6->setSection($manager->merge($this->getReference('section-1')));
        $question6->setLevel($manager->merge($this->getReference('level-1')));
        $question6->getTags()->add($manager->merge($this->getReference('tag-5')));
        $manager->persist($question6);
        
        $answers6 = array("%a", "%d", "%c", "%b");
        
        $correct = 0;
        
        foreach($answers6 as $key=>$value){
            $answer = new Answer();
            $answer->setTitle($value);
            $question5->getAnswers()->add($answer);
            $answer->setQuestion($question6);
            $answer->setCorrect(($correct === $key));
            $manager->persist($answer);
        }
        
        $question6 = new Question();
        $question6->setTitle('Which of those is not magic method?');
        $question6->setPoints(1);
        $question6->setSection($manager->merge($this->getReference('section-1')));
        $question6->setLevel($manager->merge($this->getReference('level-1')));
        $question6->getTags()->add($manager->merge($this->getReference('tag-7')));
        $manager->persist($question6);
        
        $answers6 = array("__clone", "__toString", "__toInt", "__callStatic","__sleep");
        
        $correct = 0;
        
        foreach($answers6 as $key=>$value){
            $answer = new Answer();
            $answer->setTitle($value);
            $question5->getAnswers()->add($answer);
            $answer->setQuestion($question6);
            $answer->setCorrect(($correct === $key));
            $manager->persist($answer);
        }
        
        $question6 = new Question();
        $question6->setTitle('Which function can be used to convert data into a binary string according to a specified format?');
        $question6->setPoints(1);
        $question6->setSection($manager->merge($this->getReference('section-1')));
        $question6->setLevel($manager->merge($this->getReference('level-1')));
        $question6->getTags()->add($manager->merge($this->getReference('tag-21')));
        $manager->persist($question6);
        
        $answers6 = array("encode_hex()", "nex2bin()", "pack()", "printf()");
        
        $correct = 2;
        
        foreach($answers6 as $key=>$value){
            $answer = new Answer();
            $answer->setTitle($value);
            $question5->getAnswers()->add($answer);
            $answer->setQuestion($question6);
            $answer->setCorrect(($correct === $key));
            $manager->persist($answer);
        }
        
        $question6 = new Question();
        $question6->setTitle('Which function returns an item from the argument list?');
        $question6->setPoints(1);
        $question6->setSection($manager->merge($this->getReference('section-1')));
        $question6->setLevel($manager->merge($this->getReference('level-1')));
        $question6->getTags()->add($manager->merge($this->getReference('tag-21')));
        $manager->persist($question6);
        
        $answers6 = array("func_get_arg()", "func_get_args()", "func_num_args()", "None of these");
        
        $correct = 0;
        
        foreach($answers6 as $key=>$value){
            $answer = new Answer();
            $answer->setTitle($value);
            $question5->getAnswers()->add($answer);
            $answer->setQuestion($question6);
            $answer->setCorrect(($correct === $key));
            $manager->persist($answer);
        }
        
        $question6 = new Question();
        $question6->setTitle('How do you get the number of arguments passed to a PHP function?');
        $question6->setPoints(1);
        $question6->setSection($manager->merge($this->getReference('section-1')));
        $question6->setLevel($manager->merge($this->getReference('level-1')));
        $question6->getTags()->add($manager->merge($this->getReference('tag-21')));
        $manager->persist($question6);
        
        $answers6 = array("count() function", "None of these", "\$argc variable", "\$argv variable");
        
        $correct = 1;
        
        foreach($answers6 as $key=>$value){
            $answer = new Answer();
            $answer->setTitle($value);
            $question5->getAnswers()->add($answer);
            $answer->setQuestion($question6);
            $answer->setCorrect(($correct === $key));
            $manager->persist($answer);
        }
        
        $manager->flush();
    }
    
    public function getOrder()
    {
        return 2; // the order in which fixtures will be loaded
    }
    
}