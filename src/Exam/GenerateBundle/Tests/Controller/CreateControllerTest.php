<?php

namespace Exam\GenerateBundle\Test\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;

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
    
    /**
     *
     * @var Security\AuthenticateBundle\Entity\User 
     */
    protected $user;
    
    private $username = 'david';
    private $password = 'camper';
    
    
    /**
     * Set up 
     */
    public function setUp()
    {
        $kernel = static::createKernel();
        $kernel->boot();
        
        $this->container = $kernel->getContainer();
        
        $this->router = $kernel->getContainer()->get('router');
        
        //Store the container and the entity manager in test case properties
        $this->entityManager = $kernel->getContainer()->get('doctrine.orm.entity_manager');
        
        //Load data fixtures for login in
        $classes = array(
             'Security\AuthenticateBundle\DataFixtures\ORM\UserFixtures',
             'Core\SectionBundle\DataFixtures\ORM\SectionFixtures',
             'Core\LevelBundle\DataFixtures\ORM\LevelFixtures',
             'Core\TypeBundle\DataFixtures\ORM\TypeFixtures',
             'Core\TagBundle\DataFixtures\ORM\TagFixtures',
        );

        $this->loadFixtures($classes);
        
        $this->user = $this->loadUser($this->entityManager, $this->username);
        
    }
    
    /**
     * Retrieve a User
     * @param type $doctrine
     * @param type $username
     * @return type 
     */
    private function loadUser($doctrine, $username) {
        
        // Assumes User entity implements UserInterface
        return $doctrine
                ->getRepository('SecurityAuthenticateBundle:User')
                ->findOneByUsername($username);
    }
    
    /**
     *  
     */
    public function testCreateExam_successfull()
    {
        
        $client = static::createClient();        
        $client->followRedirects(true);
        
        $crawler = $client->request('GET', '/');
        
        //Login
        $form = $crawler->selectButton('loginBtn')->form();
        $form['_username'] = $this->username;
        $form['_password'] = $this->password;

        $crawler = $client->submit($form);
        
        
        //Redirect to exam create page
        $crawler = $client->request('GET', '/exam/create');
          
        $form = $crawler->selectButton('generateExam')->form();
        
        
        //Sections
        $form['exam_generate_form[sections][0]']->tick();
        $form['exam_generate_form[sections][1]']->tick();
        
        //Number of candidates
        $form['exam_generate_form[numberCandidates]'] = 3;
        
        //Level
        $form['exam_generate_form[level]']->select(1);
        
        //Number of questions
        $form['exam_generate_form[numberQuestions]'] = 30;
        
        //Types
        $form['exam_generate_form[types][0]']->tick();
        $form['exam_generate_form[types][1]']->tick();
        $form['exam_generate_form[types][2]']->tick();
        
       
        
        //Tags
        $form['exam_generate_form[tags][0]']->tick();
        $form['exam_generate_form[tags][1]']->tick();
        $form['exam_generate_form[tags][2]']->tick();
        $form['exam_generate_form[tags][3]']->tick();
        $form['exam_generate_form[tags][4]']->tick();
        $form['exam_generate_form[tags][5]']->tick();
        
        $values = $form->getPhpValues();
        
        //var_dump($values);
        $crawler = $client->submit($form);
        
        $this->assertTrue($crawler->filter('html:contains("Your exams")')->count() > 0, $client->getResponse()->getContent());
        
        //Check database
       
        //Retreive exam object
        $exam = $this->entityManager->getRepository('ExamCoreBundle:Exam')->findOneBy(
                array('owner'=>$this->user)
                );
        
        //Section
        $sectionsActual = $exam->getExamCriteria()->getSections();
        $sectionsId = array();
        
        foreach($sectionsActual as $section){
            $sectionsId[] = $section->getId();
        }
        
        
        $sectionsExpected = $values["exam_generate_form"]["sections"];
        $this->assertEquals($sectionsExpected, $sectionsId, 'Sections');
        
        //numberCandidates
        $this->assertEquals($values["exam_generate_form"]["numberCandidates"], 
                            $exam->getExamCriteria()->getNumberCandidates(), 
                            'Number of candidates');
        
        //numberQuestions
        $this->assertEquals($values["exam_generate_form"]["numberQuestions"], 
                            $exam->getExamCriteria()->getNumberQuestions(), 
                            'Number of questions');
        
        
        //Level
        $this->assertEquals($values["exam_generate_form"]["level"], 
                            $exam->getExamCriteria()->getLevel()->getId(), 
                            'Level');
        
        //Types
        $typesActual = $exam->getExamCriteria()->getTypes();
        $typesId = array();
        
        foreach($typesActual as $type){
            $typesId[] = $type->getId();
        }
        
        $typesExpected = $values["exam_generate_form"]["types"];
        $this->assertEquals($typesExpected, $typesId, 'Types');
        
        //Tags
        $tagsActual = $exam->getExamCriteria()->getTags();
        $tagsId = array();
        
        foreach($tagsActual as $tag){
            $tagsId[] = $tag->getId();
        }
        
        $tagsExpected = $values["exam_generate_form"]["tags"];
        $this->assertEquals($tagsExpected, $tagsId, 'Tags');
    }
    
    public function testCreateExam_incomplete()
    {
        $client = static::createClient();        
        $client->followRedirects(true);
        
        $crawler = $client->request('GET', '/');
        
        //Login
        $form = $crawler->selectButton('loginBtn')->form();
        $form['_username'] = $this->username;
        $form['_password'] = $this->password;

        $crawler = $client->submit($form);
        
        //Redirect to exam create page
        $crawler = $client->request('GET', '/exam/create');
          
        $form = $crawler->selectButton('generateExam')->form();
        
        $crawler = $client->submit($form);
        
        //You must choose at least one test 
        $this->assertTrue($crawler->filter('html:contains("You must choose at least one test")')->count() > 0, $client->getResponse()->getContent());
        //You must select a number of questions
        $this->assertTrue($crawler->filter('html:contains("You must select a number of questions")')->count() > 0, $client->getResponse()->getContent());
        //You must select a level for this test
        $this->assertTrue($crawler->filter('html:contains("You must select a level for this test")')->count() > 0, $client->getResponse()->getContent());
        //You must choose at least one type of question
        $this->assertTrue($crawler->filter('html:contains("You must choose at least one type of question")')->count() > 0, $client->getResponse()->getContent());
        //You must select at least 5 topics 
        $this->assertTrue($crawler->filter('html:contains("You must select at least 5 topics")')->count() > 0, $client->getResponse()->getContent());
       
    }
    
}
