<?php

namespace Question\CreateBundle\Tests\Controller;

//use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Liip\FunctionalTestBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class CreateControllerTest extends WebTestCase
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
    
    
    private $username = 'user';
    private $password = 'userpass';
    
    
    protected function login($client, $username, $password) {
        $container = $client->getContainer();
        $doctrine = $container->get('doctrine');

        $user = $this->loadUser($doctrine, $username);

        // First Parameter is the actual user object.
        // Change 'main' to whatever your firewall is called in security.yml
        
        $container->get('security.context')->setToken(
            new UsernamePasswordToken(
                $user, $password, 'main', $user->getRoles()
            )
        );
       
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
    
    public function setUp()
    {
        $kernel = static::createKernel();
        $kernel->boot();
        
        $this->router = $kernel->getContainer()->get('router');
        
        //Store the container and the entity manager in test case properties
        $this->entityManager = $kernel->getContainer()->get('doctrine.orm.entity_manager');
    }
    
    
    public function testIndex_submit_question_one_answer()
    {
        $client = static::createClient();
        
        $client->followRedirects(true);
        
        //Load data fixtures for login in
        $classes = array(
             'Security\AuthenticateBundle\DataFixtures\ORM\UserFixtures',
        );

        $this->loadFixtures($classes);

        $client->followRedirects(true);
        $crawler = $client->request('GET', '/');

        $form = $crawler->selectButton('loginBtn')->form();
        $form['_username'] = $this->username;
        $form['_password'] = $this->password;

        $crawler = $client->submit($form);
        
        //Retrieve user
        $user = $this->loadUser($this->entityManager, $this->username);
              
        $crawler = $client->request('GET', '/question/create');
        
        $question_title = 'lorem ipsum';
        
        $form = $crawler->selectButton('_submit_question')->form(array(
            'question_create_contributor_form[title]'               => $question_title,
            'question_create_contributor_form[answers][0][title]'   => 'lorem ipsum'
        ), 'POST');
        
        $crawler = $client->submit($form);
        
        $this->assertTrue($crawler->filter('html:contains("Your question has been successfully submitted.")')->count() > 0);
        
        //Check database for question 
        $QuestionRepo = $this->entityManager->getRepository('CoreQuestionBundle:Question');
        
        $question = $QuestionRepo->findOneBy(array('title'=>$question_title, 'user'=>$user));
       
        $this->assertEquals(1, count($question));
        $this->assertEquals(0, $question->getStatus());
        $this->assertEquals(1, count($question->getAnswers()));
        
        //Check database for answer 
        $AnswerRepo = $this->entityManager->getRepository('CoreAnswerBundle:Answer');
        
        $resultAnswers = $AnswerRepo->findBy(array('question' => $question->getId()));
        
        $this->assertEquals(1, count($resultAnswers));
        
        //Check database for email saved and status code
        $EmailRepo = $this->entityManager->getRepository('MailerEmailBundle:QuestionSubmissionEmail');
        
        $resultEmail = $EmailRepo->findBy(array('question'=>$question->getId(), 'recipient'=>$user->getEmail()));
        $this->assertEquals(1, count($resultEmail));
        
         //Check database for email saved and status code
        $EmailRepo = $this->entityManager->getRepository('MailerEmailBundle:QuestionReviewEmail');
        $emailReview = $EmailRepo->findBy(array('question'=>$question->getId(), 'recipient'=>'reviewers@testyrskills.com'));
                
        $this->assertEquals(1, count($emailReview));
                 
    }
    
    public function testIndex_submit_question_one_answer_missing_question()
    {
        $client = static::createClient();

        $client->followRedirects(true);

        $client->followRedirects(true);
        $crawler = $client->request('GET', '/');

        $form = $crawler->selectButton('loginBtn')->form();
        $form['_username'] = $this->username;
        $form['_password'] = $this->password;

        $crawler = $client->submit($form);
        $crawler = $client->request('GET', '/question/create');

        $form = $crawler->selectButton('_submit_question')->form(array(
            'question_create_contributor_form[title]' => '',
            'question_create_contributor_form[answers][0][title]' => 'lorem ipsum'
                ), 'POST');

        $crawler = $client->submit($form);

        $this->assertEquals(1, $crawler->filter('html:contains("This value should not be blank.")')->count());
    }
    
    
    
    public function testIndex_submit_question_one_answer_missing_answer()
    {
        $client = static::createClient();
        
        $client->followRedirects(true);

        $client->followRedirects(true);
        $crawler = $client->request('GET', '/');

        $form = $crawler->selectButton('loginBtn')->form();
        $form['_username'] = $this->username;
        $form['_password'] = $this->password;

        $crawler = $client->submit($form);
        
        
        $crawler = $client->request('GET', '/question/create');
        
        $form = $crawler->selectButton('_submit_question')->form(array(
            'question_create_contributor_form[title]'               => 'lorem ipsum',
            'question_create_contributor_form[answers][0][title]'   => ''
        ), 'POST');
        
        $crawler = $client->submit($form);
        
        $this->assertEquals(1, $crawler->filter('html:contains("This value should not be blank.")')->count());
    }
    
    public function testIndex_submit_question_one_answer_duplicate_question()
    {
        $client = static::createClient();
        
        $client->followRedirects(true);

        $client->followRedirects(true);
        $crawler = $client->request('GET', '/');

        $form = $crawler->selectButton('loginBtn')->form();
        $form['_username'] = $this->username;
        $form['_password'] = $this->password;

        $crawler = $client->submit($form);
        
        
        $crawler = $client->request('GET', '/question/create');
        
        $form = $crawler->selectButton('_submit_question')->form(array(
            'question_create_contributor_form[title]'               => 'lorem ipsum',
            'question_create_contributor_form[answers][0][title]'   => 'lorem ipsum'
        ), 'POST');
        
        $crawler = $client->submit($form);
        
        $this->assertEquals(1, $crawler->filter('html:contains("This value is already used.")')->count() );
    }
  
}
