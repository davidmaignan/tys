<?php

namespace Question\CreateBundle\Tests\Controller;

//use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Liip\FunctionalTestBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Core\QuestionBundle\Entity\Question;
use Core\QuestionBundle\Entity\QuestionStatus;

class StatusTest extends WebTestCase
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
    
    
    private $username = 'david';
    private $password = 'camper';
    
    
    public function setUp()
    {
        $kernel = static::createKernel();
        $kernel->boot();
        
        $this->router = $kernel->getContainer()->get('router');
        
        //Store the container and the entity manager in test case properties
        $this->entityManager = $kernel->getContainer()->get('doctrine.orm.entity_manager');
    }
    
    
    private function loadUser($doctrine, $username) {
        // Assumes User entity implements UserInterface
        return $doctrine
                ->getRepository('SecurityAuthenticateBundle:User')
                ->findOneByUsername($username);
    }
    
    public function testQuestionStatusEmailSent()
    {
        
        //Load data fixtures for login in
        $classes = array(
             'Security\AuthenticateBundle\DataFixtures\ORM\UserFixtures',
        );

        $this->loadFixtures($classes);
        
        //Retrieve user
        $user = $this->loadUser($this->entityManager, $this->username);
        
        //Create Question
        $question = new Question();
        $question->setTitle('Test for sending email when changing status');
        $question->setUser($user);
        
        $this->entityManager->persist($question);
        $this->entityManager->flush();
        
        //Status 1: PENDING
        $question->setStatus(QuestionStatus::PENDING);
        $this->entityManager->persist($question);
        $this->entityManager->flush();
        /*
        //Status 2: REVIEW
        $question->setStatus(QuestionStatus::REVIEW);
        $this->entityManager->persist($question);
        $this->entityManager->flush();
        
        //Status 3: FEEDBADK
        $question->setStatus(QuestionStatus::FEEDBACK);
        $this->entityManager->persist($question);
        $this->entityManager->flush();
        
        //Status 1: PENDING
        $question->setStatus(QuestionStatus::PENDING);
        $this->entityManager->persist($question);
        $this->entityManager->flush();
        
        //Status 2: REVIEW
        $question->setStatus(QuestionStatus::REVIEW);
        $this->entityManager->persist($question);
        $this->entityManager->flush();
        
        //Status 4: APPROVED
        $question->setStatus(QuestionStatus::APPROVED);
        $this->entityManager->persist($question);
        $this->entityManager->flush();
        
        //Status 5: REJECTD
        $question->setStatus(QuestionStatus::REJECTED);
        $this->entityManager->persist($question);
        $this->entityManager->flush();
        
        //Status 6: ARCHIVED
        $question->setStatus(QuestionStatus::ARCHIVED);
        $this->entityManager->persist($question);
        $this->entityManager->flush();
        */
    }
    
}