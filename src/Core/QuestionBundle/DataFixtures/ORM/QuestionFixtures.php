<?php

namespace Core\QuestionBundle\DataFixtures\ORM;

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
        $question1->setUser($manager->merge($this->getReference('user-2')));
        $question1->setTitle('What is the result of calling json_encode() on an empty array?');
        $question1->setPoints(1);
        $question1->setSection($manager->merge($this->getReference('section-1')));
        $question1->setLevel($manager->merge($this->getReference('level-'.rand(1,4))));
        $question1->getTags()->add($manager->merge($this->getReference('tag-21')));
        $question1->setType($manager->merge($this->getReference('type')));
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
        $question2->setUser($manager->merge($this->getReference('user-2')));
        $question2->setTitle('Replace the ... by the right answer in the following PHP code : chmod ( $filename , ... );');
        $question2->setPoints(1);
        $question2->setSection($manager->merge($this->getReference('section-1')));
        $question2->setLevel($manager->merge($this->getReference('level-'.rand(1,4))));
        $question2->getTags()->add($manager->merge($this->getReference('tag-9')));
        $question2->setType($manager->merge($this->getReference('type')));
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
        $question3->setUser($manager->merge($this->getReference('user-2')));
        $question3->setTitle('Which PHP function would you use to get current session information about cookies?');
        $question3->setPoints(1);
        $question3->setSection($manager->merge($this->getReference('section-1')));
        $question3->setLevel($manager->merge($this->getReference('level-'.rand(1,4))));
        $question3->getTags()->add($manager->merge($this->getReference('tag-20')));
        $question3->setType($manager->merge($this->getReference('type')));
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
        $question4->setUser($manager->merge($this->getReference('user-2')));
        $question4->setTitle('Which one below can NOT be caught with a custom error handler?');
        $question4->setPoints(1);
        $question4->setSection($manager->merge($this->getReference('section-1')));
        $question4->setLevel($manager->merge($this->getReference('level-'.rand(1,4))));
        $question4->getTags()->add($manager->merge($this->getReference('tag-18')));
        $question4->setType($manager->merge($this->getReference('type')));
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
        $question5->setUser($manager->merge($this->getReference('user-2')));
        $question5->setTitle('is_a( $a, $b ) will:');
        $question5->setPoints(1);
        $question5->setSection($manager->merge($this->getReference('section-1')));
        $question5->setLevel($manager->merge($this->getReference('level-'.rand(1,4))));
        $question5->getTags()->add($manager->merge($this->getReference('tag-7')));
        $question5->setType($manager->merge($this->getReference('type')));
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
        $question6->setUser($manager->merge($this->getReference('user-2')));
        $question6->setTitle('Given an array of images, $images = array("img12.png", "img10.png", "img2.png", "img1.png"), which function will sort $images into ("img1.png", "img2.png", "img10.png", "img12.png")?');
        $question6->setPoints(1);
        $question6->setSection($manager->merge($this->getReference('section-1')));
        $question6->setLevel($manager->merge($this->getReference('level-'.rand(1,4))));
        $question6->getTags()->add($manager->merge($this->getReference('tag-6')));
        $question6->setType($manager->merge($this->getReference('type')));
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
        $question6->setUser($manager->merge($this->getReference('user-2')));
        $question6->setTitle('Which function would you use to obtain the ASCII value of a character?');
        $question6->setPoints(1);
        $question6->setSection($manager->merge($this->getReference('section-1')));
        $question6->setLevel($manager->merge($this->getReference('level-'.rand(1,4))));
        $question6->getTags()->add($manager->merge($this->getReference('tag-5')));
        $question6->setType($manager->merge($this->getReference('type')));
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
        $question6->setUser($manager->merge($this->getReference('user-2')));
        $question6->setTitle('Which type specifier is invalid when used within the format string argument of a printf( ) statement?');
        $question6->setPoints(1);
        $question6->setSection($manager->merge($this->getReference('section-1')));
        $question6->setLevel($manager->merge($this->getReference('level-'.rand(1,4))));
        $question6->getTags()->add($manager->merge($this->getReference('tag-5')));
        $question6->setType($manager->merge($this->getReference('type')));
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
        $question6->setUser($manager->merge($this->getReference('user-2')));
        $question6->setTitle('Which of those is not magic method?');
        $question6->setPoints(1);
        $question6->setSection($manager->merge($this->getReference('section-1')));
        $question6->setLevel($manager->merge($this->getReference('level-'.rand(1,4))));
        $question6->getTags()->add($manager->merge($this->getReference('tag-7')));
        $question6->setType($manager->merge($this->getReference('type')));
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
        $question6->setUser($manager->merge($this->getReference('user-2')));
        $question6->setTitle('Which function can be used to convert data into a binary string according to a specified format?');
        $question6->setPoints(1);
        $question6->setSection($manager->merge($this->getReference('section-1')));
        $question6->setLevel($manager->merge($this->getReference('level-'.rand(1,4))));
        $question6->getTags()->add($manager->merge($this->getReference('tag-21')));
        $question6->setType($manager->merge($this->getReference('type')));
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
        $question6->setUser($manager->merge($this->getReference('user-2')));
        $question6->setTitle('Which function returns an item from the argument list?');
        $question6->setPoints(1);
        $question6->setSection($manager->merge($this->getReference('section-1')));
        $question6->setLevel($manager->merge($this->getReference('level-'.rand(1,4))));
        $question6->getTags()->add($manager->merge($this->getReference('tag-21')));
        $question6->setType($manager->merge($this->getReference('type')));
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
        $question6->setUser($manager->merge($this->getReference('user-2')));
        $question6->setTitle('How do you get the number of arguments passed to a PHP function?');
        $question6->setPoints(1);
        $question6->setSection($manager->merge($this->getReference('section-1')));
        $question6->setLevel($manager->merge($this->getReference('level-'.rand(1,4))));
        $question6->getTags()->add($manager->merge($this->getReference('tag-21')));
        $question6->setType($manager->merge($this->getReference('type')));
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
        
        $question6 = new Question();
        $question6->setUser($manager->merge($this->getReference('user-2')));
        $question6->setTitle('What does the use of the final keyword in a method declaration prevent?');
        $question6->setPoints(1);
        $question6->setSection($manager->merge($this->getReference('section-1')));
        $question6->setLevel($manager->merge($this->getReference('level-'.rand(1,4))));
        $question6->getTags()->add($manager->merge($this->getReference('tag-21')));
        $question6->setType($manager->merge($this->getReference('type')));
        $manager->persist($question6);
        
        $answers6 = array("Child classes from overriding the method.", "Objects from being modified.", 
            "All of these", "Specific properties within a class from being modified.");
        
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
        $question6->setUser($manager->merge($this->getReference('user-2')));
        $question6->setTitle('Which character is used to separate namespaces in PHP?');
        $question6->setPoints(1);
        $question6->setSection($manager->merge($this->getReference('section-1')));
        $question6->setLevel($manager->merge($this->getReference('level-'.rand(1,4))));
        $question6->getTags()->add($manager->merge($this->getReference('tag-21')));
        $question6->setType($manager->merge($this->getReference('type')));
        $manager->persist($question6);
        
        $answers6 = array("Period(.)", "Backslash (\)", 
            "Double colon (::)", "Arrow(->)");
        
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
        $question6->setUser($manager->merge($this->getReference('user-2')));
        $question6->setTitle('Which PHP function checks a month, day, and year number to determine if they form a valid Gregorian date?');
        $question6->setPoints(1);
        $question6->setSection($manager->merge($this->getReference('section-1')));
        $question6->setLevel($manager->merge($this->getReference('level-'.rand(1,4))));
        $question6->getTags()->add($manager->merge($this->getReference('tag-21')));
        $question6->setType($manager->merge($this->getReference('type')));
        $manager->persist($question6);
        
        $answers6 = array("verify_date()", "verifydate()", "check_date()", "checkdate()");
        
        $correct = 3;
        
        foreach($answers6 as $key=>$value){
            $answer = new Answer();
            $answer->setTitle($value);
            $question5->getAnswers()->add($answer);
            $answer->setQuestion($question6);
            $answer->setCorrect(($correct === $key));
            $manager->persist($answer);
        }
        
        $question6 = new Question();
        $question6->setUser($manager->merge($this->getReference('user-2')));
        $question6->setTitle('What does mt_srand( [int $a] ); do?');
        $question6->setPoints(1);
        $question6->setSection($manager->merge($this->getReference('section-1')));
        $question6->setLevel($manager->merge($this->getReference('level-'.rand(1,4))));
        $question6->getTags()->add($manager->merge($this->getReference('tag-21')));
        $question6->setType($manager->merge($this->getReference('type')));
        $manager->persist($question6);
        
        $answers6 = array("Subtracts a random integer from the passed argument and returns the result", 
            "Returns a random integer", "Initializes a random number generator",
            "Returns a random string of the length specified by the first argument",
            "This function does not exist");
        
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
        $question6->setUser($manager->merge($this->getReference('user-2')));
        $question6->setTitle('Choose the correct output of:');
        $question6->setCode('<?php $email=\'admin@psexam.com\'; $new=strstr($email, \'@\'); print $new; ?>');
        $question6->setPoints(1);
        $question6->setSection($manager->merge($this->getReference('section-1')));
        $question6->setLevel($manager->merge($this->getReference('level-'.rand(1,4))));
        $question6->getTags()->add($manager->merge($this->getReference('tag-21')));
        $question6->setType($manager->merge($this->getReference('type')));
        $manager->persist($question6);
        
        $answers6 = array("admin@psexam", "admin", "@psexam.com", "psexam.com");
        
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
        $question6->setUser($manager->merge($this->getReference('user-2')));
        $question6->setTitle('What does the glob() function return?');
        $question6->setPoints(1);
        $question6->setSection($manager->merge($this->getReference('section-1')));
        $question6->setLevel($manager->merge($this->getReference('level-'.rand(1,4))));
        $question6->getTags()->add($manager->merge($this->getReference('tag-21')));
        $question6->setType($manager->merge($this->getReference('type')));
        $manager->persist($question6);
        
        $answers6 = array("An array of filenames / directories matching a specified pattern", 
            "All system global variables", 
            "An array of all global variables into the user defined function");
        
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
        $question6->setUser($manager->merge($this->getReference('user-2')));
        $question6->setTitle('Value of $i ?');
        $question6->setCode('<?php
                                function increment(&$in) {
                                    $in++;
                                }
                                $i = 1;
                                increment(--$i);
                                ?>');
        $question6->setPoints(1);
        $question6->setSection($manager->merge($this->getReference('section-1')));
        $question6->setLevel($manager->merge($this->getReference('level-'.rand(1,4))));
        $question6->getTags()->add($manager->merge($this->getReference('tag-21')));
        $question6->setType($manager->merge($this->getReference('type')));
        $manager->persist($question6);
        
        $answers6 = array("1", "3", "Syntax error","0", "2");
        
        $correct = 3;
        
        foreach($answers6 as $key=>$value){
            $answer = new Answer();
            $answer->setTitle($value);
            $question5->getAnswers()->add($answer);
            $answer->setQuestion($question6);
            $answer->setCorrect(($correct === $key));
            $manager->persist($answer);
        }
        
        $question6 = new Question();
        $question6->setUser($manager->merge($this->getReference('user-2')));
        $question6->setTitle('To determine if the file pointer is at the end of a successfully opened file, use the...');
        $question6->setPoints(1);
        $question6->setSection($manager->merge($this->getReference('section-1')));
        $question6->setLevel($manager->merge($this->getReference('level-'.rand(1,4))));
        $question6->getTags()->add($manager->merge($this->getReference('tag-21')));
        $question6->setType($manager->merge($this->getReference('type')));
        $manager->persist($question6);
        
        $answers6 = array("eof() function.", "feof() function.", "\$file_end variable.","\$end variable.");
        
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
        $question6->setUser($manager->merge($this->getReference('user-2')));
        $question6->setTitle('Choose the resulting output of: ');
        $question6->setCode('$x = array(1,3,2,3,7,8,9,7,3);        
                             $y = array_count_values($x);
                             echo $y[8];');
        $question6->setPoints(1);
        $question6->setSection($manager->merge($this->getReference('section-1')));
        $question6->setLevel($manager->merge($this->getReference('level-'.rand(1,4))));
        $question6->getTags()->add($manager->merge($this->getReference('tag-21')));
        $question6->setType($manager->merge($this->getReference('type')));
        $manager->persist($question6);
        
        $answers6 = array("43", "1", "3","7");
        
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
        $question6->setUser($manager->merge($this->getReference('user-2')));
        $question6->setTitle('What is T_PAAMAYIM_NEKUDOTAYIM?');
        $question6->setPoints(1);
        $question6->setSection($manager->merge($this->getReference('section-1')));
        $question6->setLevel($manager->merge($this->getReference('level-'.rand(1,4))));
        $question6->getTags()->add($manager->merge($this->getReference('tag-21')));
        $question6->setType($manager->merge($this->getReference('type')));
        $manager->persist($question6);
        
        $answers6 = array("The scope resolution token ::", "The xor equal operator ^=",
            "The goto token","The object operator ->", "The $ before a variable name");
        
        $correct = 0;
        
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
        return 6; // the order in which fixtures will be loaded
    }
    
}