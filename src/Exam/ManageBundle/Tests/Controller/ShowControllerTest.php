<?php

namespace Exam\ManageBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;

class ShowControllerTest extends WebTestCase
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
     * @var Doctrine\ORM\EntityManager 
     */
    protected $entityManager;
    
    /**
     * @var string
     */
    private $username = 'user';
    
    /**
     * @var string 
     */
    private $password = 'userpass';
    
    /**
     * @var string
     */
    private $username2 = 'david';
    
    /**
     * @var string 
     */
    private $password2 = 'camper';
    
    /**
     * @var string
     */
    private $usernameAdmin = 'admin';
    
    /**
     * @var string 
     */
    private $passwordAdmin = 'adminpass';
    
    /**
     * @var array 
     */
    private $classes = array(
             'Security\AuthenticateBundle\DataFixtures\ORM\UserFixtures',
             'Core\SectionBundle\DataFixtures\ORM\SectionFixtures',
             'Core\LevelBundle\DataFixtures\ORM\LevelFixtures',
             'Core\TypeBundle\DataFixtures\ORM\TypeFixtures',
             'Core\TagBundle\DataFixtures\ORM\TagFixtures',
             'Exam\CoreBundle\DataFixtures\ORM\ExamFixtures',
            );
    
    /**
     * Retreive user
     * @param type $doctrine
     * @param type $username
     * @return type 
     */
    private function loadUser($doctrine, $username) {
        return $doctrine
                ->getRepository('SecurityAuthenticateBundle:User')
                ->findOneByUsername($username);
    }
    
    /**
     * Set up test 
     */
    public function setUp()
    {
        $kernel = static::createKernel();
        $kernel->boot();
        
        $this->router = $kernel->getContainer()->get('router');
        
        //Store the container and the entity manager in test case properties
        $this->entityManager = $kernel->getContainer()->get('doctrine.orm.entity_manager');
    }
    
    /**
     * Test list exams 
     */
    public function test_show_exam_send_invitation() {
        
        $user = $this->loadUser($this->entityManager, $this->username);
        
        if(!$user) {
            $this->loadFixtures($this->classes);
            $user = $this->loadUser($this->entityManager, $this->username);
        }
         
        $client = static::createClient();        
        $client->followRedirects(true);
        
        $crawler = $client->request('GET', '/');
        
        //Login
        $form = $crawler->selectButton('loginBtn')->form();
        $form['_username'] = $this->username;
        $form['_password'] = $this->password;
        $crawler = $client->submit($form);
        
        $exam = $this->entityManager->getRepository('ExamCoreBundle:Exam')->findOneBy(array('owner'=>$user));
        
        $url = $this->router->generate('exam_manage_show', array('id'=>$exam->getId()));
       
        $crawler = $client->request('GET',  $url);
        
        $this->assertTrue($crawler->filter('html:contains("Your exam")')->count() > 0);
        
        $form = $crawler->selectButton('sendInvitation')->form(array(
            'exam_send_invitation[email]' =>'test@test.com',
            'exam_send_invitation[first_name]' =>'test',
            'exam_send_invitation[last_name]' =>'test',
        ), 'post');
         
        $crawler = $client->submit($form);
        
        $this->assertEquals('"invitation sent successfully"', $client->getResponse()->getContent());
        //$this->assertEquals('application/json', $client->getResponse()->getHeaders());
        
        //Check db for email send / save
        $email = $this->entityManager->getRepository('MailerEmailBundle:SendInvitationEmail')->findOneBy(array('recipient'=>'test@test.com'));
        
        $this->assertEquals(1, count($email));
        
    }
    
    public function test_no_exam_found() {
        $user = $this->loadUser($this->entityManager, $this->username);
        
        if(!$user) {
            $this->loadFixtures($this->classes);
            $user = $this->loadUser($this->entityManager, $this->username);
        }
         
        $client = static::createClient();        
        $client->followRedirects(true);
        
        $crawler = $client->request('GET', '/');
        
        //Login
        $form = $crawler->selectButton('loginBtn')->form();
        $form['_username'] = $this->usernameAdmin;
        $form['_password'] = $this->passwordAdmin;
        $crawler = $client->submit($form);
        
        $exam = $this->entityManager->getRepository('ExamCoreBundle:Exam')->findOneBy(array('owner'=>$user));
        
        $url = $this->router->generate('exam_manage_show', array('id'=>$exam->getId()));
       
        $crawler = $client->request('GET',  $url);
        
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }
    
}
