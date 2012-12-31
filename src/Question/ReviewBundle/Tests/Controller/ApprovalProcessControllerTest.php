<?php

namespace Question\ReviewBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;
use Core\QuestionBundle\Entity\QuestionStatus;

class ApprovalProcessControllerTest extends WebTestCase
{
    
    /**
     * @var Doctrine\ORM\EntityManager 
     */
    private $repo;
    
    /**
     * @var Symfony\Bundle\FrameworkBundle\Routing\Router;
     */
    private $router;
    
    /**
     * @var Symfony\Component\DependencyInjection\Container 
     */
    protected $container;
    
    
    /**
     *
     * @var Doctrine\ORM\EntityManager 
     */
    protected $entityManager;
    
    
    private $username = 'admin';
    private $password = 'adminpass';
    
    private $usernameUser = 'user';
    private $passwordUser = 'userpass';
    
    private $questionID;
    
    private $classes = array(
             'Security\AuthenticateBundle\DataFixtures\ORM\UserFixtures',
             'Core\QuestionBundle\DataFixtures\ORM\QuestionFixtures',
             'Core\LevelBundle\DataFixtures\ORM\LevelFixtures',
             'Core\SectionBundle\DataFixtures\ORM\SectionFixtures',
             'Core\TypeBundle\DataFixtures\ORM\TypeFixtures',
             'Core\TagBundle\DataFixtures\ORM\TagFixtures',
            );
    
    
    public function setUp()
    {
        $kernel = static::createKernel();
        $kernel->boot();
        
        $this->router = $kernel->getContainer()->get('router');
        
        //Store the container and the entity manager in test case properties
        $this->entityManager = $kernel->getContainer()->get('doctrine.orm.entity_manager');
    }
    
    private function loadUser($doctrine, $username) {
        // Don't have to use doctrine if you don't want to, you could use
        // a service to load your user since you have access to the
        // container.

        // Assumes User entity implements UserInterface
        return $doctrine
                ->getRepository('SecurityAuthenticateBundle:User')
                ->findOneByUsername($username);
    }
    
    /**
     * Retreive one question
     * @return Core\QuestionBundle\Entity\Question $question 
     */
    private function getQuestion()
    {
        $questions  = $this->entityManager->getRepository('CoreQuestionBundle:Question')->findAll();
        return reset($questions);
    }
    
    private function getQuestionById($id)
    {
        return $this->entityManager->getRepository('CoreQuestionBundle:Question')->find($id);
    }
    
    public function getEmail($entity, $parameters)
    {
        return $this->entityManager->getRepository($entity)->findOneBy($parameters);
    }
    
    
    public function test_approval_process_step_1()
    {
        
       $this->loadFixtures($this->classes);
        
       $client = static::createClient(); 
       $client->followRedirects(true);
       
       //Let's login as an reviewer
       $crawler = $client->request('GET', '/');

       $form = $crawler->selectButton('loginBtn')->form();
       $form['_username'] = $this->username;
       $form['_password'] = $this->password;

       $crawler = $client->submit($form);
       
       //Retreive one question for approval
       
       $question = $this->getQuestion();
       $questionID = $question->getId();
       $this->questionID = $questionID;
       
       $uri = $this->router->generate('question_review_show', array('id'=>$questionID));
       
       //$uri = "/question/review/show/$questionID";
       
       $crawler = $client->request('GET', $uri);
       
       $linkUri = $crawler->filterXPath('//*[@id=\'question-ask-feedback\']')->link()->getUri();
       
       $this->assertEquals("http://localhost/question/feedback/request/$questionID" , $linkUri);
       
       //Request a feedback - change status of question to 3 - send an QuestionFeedbackEmail to owner 
       $uri = $this->router->generate('question_reviewer_ask_feedback', array('id'=>$questionID));
       $crawler = $client->request('GET', $uri);
        
       //Check landing on the right page - list of question to review without this one
       $this->assertTrue($crawler->filter('html:contains("A question is waiting for your review")')->count() > 0);
       
       //Check question is not in the list of result for review
       $this->assertEquals(0, $crawler->filter('html:contains("'.$question->getTitle().'")')->count());
       
       //Check Email was sent
       $email = $this->getEmail('MailerEmailBundle:QuestionFeedbackEmail', array('recipient'=>$question->getUser()->getEmail(), 'question'=>$question));       
       $this->assertEquals(count($email), 1);
       
       
       //Check status of the question       
       $questionUpdated = $this->entityManager->getRepository('CoreQuestionBundle:Question')->findOneBy(array('status'=> QuestionStatus::FEEDBACK));
       $this->assertEquals($questionID, $questionUpdated->getId());
       
    }
    
     /**
     * @depends test_approval_process_step_1
     */
    public function test_approval_process_step_2()
    {
       $client = static::createClient(); 
       $client->followRedirects(true);
       
       //Let's login as an reviewer
       $crawler = $client->request('GET', '/');

       $form = $crawler->selectButton('loginBtn')->form();
       $form['_username'] = $this->usernameUser;
       $form['_password'] = $this->passwordUser;

       $crawler = $client->submit($form);
       
       $question = $this->entityManager->getRepository('CoreQuestionBundle:Question')->findOneBy(array('status'=> QuestionStatus::FEEDBACK));
       $questionID = $question->getId();
       
       $uri = $this->router->generate('question_feedback_show', array('id'=>$questionID));
       $crawler = $client->request('GET',$uri);
       
       $this->assertEquals(1, $crawler->filter('html:contains("'.$question->getTitle().'")')->count());
       
       //Check link for 
       $linkUri = $crawler->filterXPath('//*[@id=\'question-send-approval\']')->link()->getUri();
       $this->assertEquals("http://localhost/question/review/ask/approval/$questionID" , $linkUri);
       
       $uri = $this->router->generate('question_owner_ask_approval', array('id'=>$questionID));
       $crawler = $client->request('GET', $uri);
       
       //Check landing on the right page - list of question to review without this one
       $this->assertTrue($crawler->filter('html:contains("Your list of questions")')->count() > 0);
       
       //Check Email was sent
       $email = $this->getEmail('MailerEmailBundle:QuestionReviewEmail', array('recipient'=>'reviewers@testyrskills.com', 'question'=>$question));       
       $this->assertEquals(count($email), 1);
       
       $questionUpdated = $this->entityManager->getRepository('CoreQuestionBundle:Question')->findOneBy(array('status'=> QuestionStatus::PENDING));       
       $this->assertEquals($questionID, $questionUpdated->getId());
       
    }
    
    /**
     * Test access  
     */
    public function test_review_wrong_credential()
    {
       $client = static::createClient(); 
       $client->followRedirects(true);
       
       //Let's login as an reviewer
       $crawler = $client->request('GET', '/');

       $form = $crawler->selectButton('loginBtn')->form();
       $form['_username'] = $this->usernameUser;
       $form['_password'] = $this->passwordUser;
       
       $crawler = $client->submit($form);
       
       $uri = $this->router->generate('question_review_list');
       
       $crawler = $client->request('GET', $uri);
       
       $this->assertEquals(403, $client->getResponse()->getStatusCode());
       
       $question = $this->getQuestion();
       $questionID = $question->getId();
       $this->questionID = $questionID;
       
       
       $uri = $this->router->generate('question_review_show', array('id'=>$questionID));
       
       $crawler = $client->request('GET', $uri);
       
       $this->assertEquals(403, $client->getResponse()->getStatusCode()); 
       
       
        $question = $this->getQuestion();
       $questionID = $question->getId();
       $this->questionID = $questionID;
       
       $uri = $this->router->generate('question_review_edit', array('id'=>$questionID));
       
       $crawler = $client->request('GET', $uri);
       
       $this->assertEquals(403, $client->getResponse()->getStatusCode());     
    }
    
   
    
}
