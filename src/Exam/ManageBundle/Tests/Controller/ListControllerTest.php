<?php

namespace Exam\ManageBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;

class ListControllerTest extends WebTestCase
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
    private $usernameForbidden = 'david';
    
    /**
     * @var string 
     */
    private $passwordForbidden = 'camper';
    
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
    public function test_list_exams_index() {
        
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
        
        $url = $this->router->generate('exam_manage_homepage');
        
        //Redirect to exam list page
        $crawler = $client->request('GET',  $url);
        
        $this->assertTrue($crawler->filter('html:contains("Your exams")')->count() > 0);
        $this->assertEquals(1, $crawler->filterXPath('//*[@id=\'exam-list\']/tbody/tr')->count());
        
        $link = $crawler->filterXPath('//*[@id=\'exam-list\']/tbody/tr/td[6]/a')->link();
        
        $crawler = $client->click($link);
        
        $this->assertTrue($crawler->filter('html:contains("Your exam")')->count() > 0);
        
    }
    
    /**
     * Test access denied for non ROLE_EXAM_OWNER 
     */
    public function test_list_access_forbidden () {
        
        $user = $this->loadUser($this->entityManager, $this->username);
        
        if(!$user) {
            $this->loadFixtures($this->classes);
        }
        
        
        $client = static::createClient();        
        $client->followRedirects(true);
        
        $crawler = $client->request('GET', '/');
        
        //Login
        $form = $crawler->selectButton('loginBtn')->form();
        $form['_username'] = $this->usernameForbidden;
        $form['_password'] = $this->passwordForbidden;
        $crawler = $client->submit($form);
        
        $url = $this->router->generate('exam_manage_homepage');
        
        //Redirect to exam list page
        $crawler = $client->request('GET',  $url);
        
        $this->assertEquals(403, $client->getResponse()->getStatusCode());
    }
    
    
}
