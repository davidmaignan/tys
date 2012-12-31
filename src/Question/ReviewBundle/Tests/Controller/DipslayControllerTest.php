<?php

namespace Question\ReviewBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;
use Core\QuestionBundle\Entity\QuestionStatus;

class DipslayControllerTest extends WebTestCase
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
    
    /**
     * Test edit / show - question with wrong status 
     * Return 404
     */
    public function test_reviewer_show_edit_question_wrong_status()
    {
        
       $this->loadFixtures($this->classes); 
        
       $client = static::createClient(); 
       $client->followRedirects(true);
       $crawler = $client->request('GET', '/');

       $form = $crawler->selectButton('loginBtn')->form();
       $form['_username'] = $this->username;
       $form['_password'] = $this->password;
       $crawler = $client->submit($form);
       
       $question = $this->getQuestion();
       $questionID = $question->getId();
       
       //Update the status to 3
       $this->entityManager->getRepository('CoreQuestionBundle:Question')->updateStatus($question->getId(), QuestionStatus::FEEDBACK);
       
       $question = $this->getQuestionById($questionID);
       
       $uri = $this->router->generate('question_review_edit', array('id'=>$questionID));
       $crawler = $client->request('GET', $uri);
       $this->assertEquals(404, $client->getResponse()->getStatusCode());
       
       $uri = $this->router->generate('question_review_show', array('id'=>$questionID));
       $crawler = $client->request('GET', $uri);
       $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }
    
     /**
     * Test edit / show - question with wrong status 
     * Return 404
     */
    public function test_reviewer_show_edit_question_wrong_credential()
    {
        
        
       $client = static::createClient(); 
       $client->followRedirects(true);
       $crawler = $client->request('GET', '/');

       $form = $crawler->selectButton('loginBtn')->form();
       $form['_username'] = $this->usernameUser;
       $form['_password'] = $this->passwordUser;
       $crawler = $client->submit($form);
       
       $question = $this->getQuestion();
       $questionID = $question->getId();
       
      
       $uri = $this->router->generate('question_review_edit', array('id'=>$questionID));
       $crawler = $client->request('GET', $uri);
       $this->assertEquals(403, $client->getResponse()->getStatusCode());
       
       $uri = $this->router->generate('question_review_show', array('id'=>$questionID));
       $crawler = $client->request('GET', $uri);
       $this->assertEquals(403, $client->getResponse()->getStatusCode());
    }
    
}
