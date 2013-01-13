<?php

namespace Question\ReviewBundle\Tests\Controller;

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
    
    
    public function test_list_questions_reviewer_language()
    {
       //Load data fixtures for login in
        $this->loadFixtures($this->classes);
        
       $client = static::createClient(); 
       $client->followRedirects(true);
       
       $crawler = $client->request('GET', '/');

       $form = $crawler->selectButton('loginBtn')->form();
       $form['_username'] = $this->username;
       $form['_password'] = $this->password;

       $crawler = $client->submit($form);
       
       $crawler = $client->request('GET', '/question/review/list');
       
       $this->assertEquals(1, $crawler->filter('h1')->count());
       $this->assertEquals(9, $crawler->filter('tr')->count());
       
       $messages = array(1=>"PHP","PHP","PHP","PHP","Javascript","Javascript","Javascript","Javascript");
       
       foreach ($messages as $key => $value) {
           $message = $crawler->filterXPath("//table/tbody/tr[$key]/td[3]")->text();
           $this->assertEquals($value, $message);
       }
        
    }
    
    public function test_list_questions_wrong_credential()
    {
       $client = static::createClient(); 
       $client->followRedirects(true);
       $crawler = $client->request('GET', '/');

       $form = $crawler->selectButton('loginBtn')->form();
       $form['_username'] = $this->usernameUser;
       $form['_password'] = $this->passwordUser;
       $crawler = $client->submit($form);
       
       $crawler = $client->request('GET', '/question/review/list');
       $this->assertEquals(403, $client->getResponse()->getStatusCode());
    }
    
    public function test_list_show_edit_comment_reviewer()
    {
       
        
       $client = static::createClient(); 
       $client->followRedirects(true);
       
       $crawler = $client->request('GET', '/');
       $form = $crawler->selectButton('loginBtn')->form();
       $form['_username'] = $this->username;
       $form['_password'] = $this->password;

       $crawler = $client->submit($form);
       
       $uri = $this->router->generate('question_review_list');
       $crawler = $client->request('GET', $uri);
       
       $title = $crawler->filterXPath('//table[contains(@class, \'question-list\')]/tbody/tr[1]/td[2]')->text();
       
       $linkUri = $crawler->filterXPath('//table[contains(@class, \'question-list\')]/tbody/tr[1]/td[7]/a')->link()->getUri();
       
       
       $uri = explode('/', $linkUri);
       $questionID = (int)(end($uri));
       
       $user = $this->loadUser($this->entityManager, $this->username);
       $userID = $user->getId();
       
       $crawler = $client->request('GET', $linkUri);
       
       $titleShow = $crawler->filterXPath('//table[contains(@class, \'question-show\')]/tbody/tr[1]/td[2]')->text();
       $this->assertEquals($title, $titleShow);
       
       //Number of answers
       $answers = $crawler->filterXPath('//table[contains(@class, \'question-show\')]/tbody/tr[9]/td[2]/ul')->children();
       $this->assertEquals(4, count($answers));
       
       
       //Go to edit page
       $linkUri = $crawler->filterXPath('//*[@id=\'question-edit\']')->link()->getUri();
       
       $crawler = $client->request('GET', $linkUri);
       
       //Check title
       $datas = array('title'=>array('id'=>'//*[@id=\'question_review_reviewer_form_title\']',
                                     'value'=>'What is the result of calling json_encode() on an empty array?'),
                      'correct_answer'=>array('id'=>'//*[@id=\'question_review_reviewer_form_answers_0_title\']',
                                     'value'=>'\'\' - An empty JavaScript string'),
                      'wrong_answer_1'=>array('id'=>'//*[@id=\'question_review_reviewer_form_answers_1_title\']',
                                     'value'=>'{} - An empty JavaScript object'),
                      'wrong_answer_1'=>array('id'=>'//*[@id=\'question_review_reviewer_form_answers_2_title\']',
                                     'value'=>'[] - An empty JavaScript array'),
                      'wrong_answer_1'=>array('id'=>'//*[@id=\'question_review_reviewer_form_answers_3_title\']',
                                     'value'=>'undefined')
                );

       foreach ($datas as $key => $value) {
           $this->assertEquals($value['value'],$crawler->filterXPath($value['id'])->text());
       };
       
       //Set last answer to empty string - submit the form - check
       
       
       $form = $crawler->selectButton('back-list')->form();
       $form['question_review_reviewer_form[answers][3][title]'] = '';
       $form['question_review_reviewer_form[points]'] = 0;
       $crawler = $client->submit($form);
       
       $this->assertTrue($crawler->filter('html:contains("This value should not be blank.")')->count() > 0);
       $this->assertTrue($crawler->filter('html:contains(" You need to attribute at least 1 point.")')->count() > 0);
       
       
       //Create a comment
       $commentText = "Test posting a comment for question with id $questionID";
       $commentForm = $crawler->selectButton('post-comment')->form();
       $commentForm['question_review_comment_form[body]'] = $commentText;
       $crawler = $client->submit($commentForm);
       
       //Check db if comment is saved
       $commentRepository = $this->entityManager->getRepository('CoreCommentBundle:Comment');
       
       $comment = $commentRepository->findBy(array('question'=>$questionID, 'user'=>$userID));
       
       $this->assertEquals(1, count($comment));
       $this->assertEquals($commentText, $comment[0]->getBody());
       
       //Check dom if comment is there
       $this->assertTrue($crawler->filter('html:contains("' . $commentText . '")')->count() > 0);
       
       
    }
    
}
