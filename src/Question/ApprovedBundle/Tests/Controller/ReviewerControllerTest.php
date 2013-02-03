<?php

namespace Question\ApprovedBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;

use Core\QuestionBundle\Entity\Question;
use Core\QuestionBundle\Entity\QuestionStatus;

use Doctrine\ORM\EntityManager;

class ReviewerControllerTest extends WebTestCase
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
    
    private $classes = array(
             'Security\AuthenticateBundle\DataFixtures\ORM\UserFixtures',
             'Core\LevelBundle\DataFixtures\ORM\LevelFixtures',
             'Core\SectionBundle\DataFixtures\ORM\SectionFixtures',
             'Core\TypeBundle\DataFixtures\ORM\TypeFixtures',
             'Core\TagBundle\DataFixtures\ORM\TagFixtures',
             'Core\QuestionBundle\DataFixtures\ORM\QuestionFixtures',
            );
    
    
    public function setUp()
    {
        $kernel = static::createKernel();
        $kernel->boot();
        
        $this->router = $kernel->getContainer()->get('router');
        
        //Store the container and the entity manager in test case properties
        $this->entityManager = $kernel->getContainer()->get('doctrine.orm.entity_manager');
        
    }
    
    private function loadUser(EntityManager $doctrine, $username) {
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
    
    /**
     *
     * @param type $parameters
     * @return Question 
     */
    private function getQuestionByParameters($parameters)
    {
        return $this->entityManager->getRepository('CoreQuestionBundle:Question')->findOneBy($parameters);
    }
    
    /**
     *
     * @param string $entity
     * @param array $parameters
     * @return Email 
     */
    public function getEmail($entity, $parameters)
    {
        return $this->entityManager->getRepository($entity)->findOneBy($parameters);
    }
    
    /**
     * Test approve question - wrong login
     * Return 403
     */
    public function test_reviewer_approved_wrong_credential()
    {
       $this->loadFixtures($this->classes);
        
       $client = static::createClient(); 
       $client->followRedirects(true);
       $crawler = $client->request('GET', '/');

       $form = $crawler->selectButton('loginBtn')->form();
       $form['_username'] = $this->usernameUser;
       $form['_password'] = $this->passwordUser;
       $crawler = $client->submit($form);
       
       $question = $this->getQuestion();
       $questionID = $question->getId();
       $question->setStatus(QuestionStatus::REVIEW);
       $this->entityManager->flush();
       
       $uri = $this->router->generate('question_review_approved', array('id'=>$questionID));
       $crawler = $client->request('GET', $uri);
       $this->assertEquals(403, $client->getResponse()->getStatusCode());
    }
    
    /**
     * Test approve question - wrong status
     * Return 404
     */
    public function test_reviewer_approved_wrong_status()
    {
       $client = static::createClient(); 
       $client->followRedirects(true);
       $crawler = $client->request('GET', '/');

       $form = $crawler->selectButton('loginBtn')->form();
       $form['_username'] = $this->username;
       $form['_password'] = $this->password;
       $crawler = $client->submit($form);
       
       $question = $this->getQuestion();      
       $questionID = $question->getId();
       $question->setStatus(QuestionStatus::FEEDBACK);
       $this->entityManager->flush();
      
       $uri = $this->router->generate('question_review_approved', array('id'=>$questionID));
       $crawler = $client->request('GET', $uri);
       
       $this->assertEquals(404, $client->getResponse()->getStatusCode());
       
    }
    
    public function test_reviewer_approved_success()
    {
       $client = static::createClient(); 
       $client->followRedirects(true);
       $crawler = $client->request('GET', '/');

       $form = $crawler->selectButton('loginBtn')->form();
       $form['_username'] = $this->username;
       $form['_password'] = $this->password;
       $crawler = $client->submit($form);
       
       $question = $this->getQuestion();
       $questionID = $question->getId();
       $question->setStatus(QuestionStatus::REVIEW);
       $this->entityManager->flush();
      
       $uri = $this->router->generate('question_review_approved', array('id'=>$questionID));
       $crawler = $client->request('GET', $uri);
       
       $this->assertEquals(200, $client->getResponse()->getStatusCode());
       
       return $questionID;
    }
    
    /**
     * @depends test_reviewer_approved_success
     */
    public function test_check_question_status($questionID)
    {
        //Check status code for question
       $questionUpdated = $this->getQuestionByParameters(array('status'=>  QuestionStatus::APPROVED));

       $this->assertEquals(1, count($questionUpdated));
       $this->assertEquals($questionID, $questionUpdated->getId());       
    }
    
    /**
     * @depends test_reviewer_approved_success
     */
    public function test_email_sent_to_owner($questionID)
    {
        $question = $this->getQuestionByParameters(array('id'=>$questionID));
        $email = $this->getEmail('MailerEmailBundle:QuestionApprovedEmail', array('question'=>$question, 'recipient'=>$question->getUser()->getEmail()));
        $this->assertEquals(1, count($email));
    }
}
