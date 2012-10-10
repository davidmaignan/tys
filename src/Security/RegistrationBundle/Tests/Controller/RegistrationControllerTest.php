<?php

namespace Security\RegistrationBundle\Tests\Controller;

//require_once dirname(__DIR__).'/../../../../app/AppKernel.php';

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegistrationControllerTest extends WebTestCase
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
     * @var email 
     */
    private $email = 'teadsfasdfasstfgd@test.com';
    
    public function setUp()
    {
        $kernel = static::createKernel();
        $kernel->boot();
        
        $this->router = $kernel->getContainer()->get('router');
        
        //Store the container and the entity manager in test case properties
        $this->entityManager = $kernel->getContainer()->get('doctrine.orm.entity_manager');
    }
    
    
    public function testRegistration_successful () 
    {
        $client = static::createClient();
        
        $client->followRedirects(true);
        
        $crawler = $client->request('GET', '/register/');
        
        $form = $crawler->selectButton('_register')->form();
        
        $form['fos_user_registration_form[username]'] = 'afadsfasdffdgfgd';
        $form['fos_user_registration_form[email]'] = $this->email;
        $form['fos_user_registration_form[plainPassword][first]'] = 'camper';
        $form['fos_user_registration_form[plainPassword][second]'] = 'camper';

        $crawler = $client->submit($form);
        
        $this->assertTrue($crawler->filter('html:contains("Congratulations")')->count() > 0, $client->getResponse()->getContent());
        
        $this->repo = $this->entityManager->getRepository('MailerEmailBundle:Email');
        
        $this->assertEquals(1, count($this->repo->findOneBy(array('recipient'=>$this->email))));
    }
    
    public function testActivation_link(){
        
        $email = $this->entityManager->getRepository('MailerEmailBundle:Email')->findOneBy(array('recipient'=>$this->email));
        
        $link = $this->router->generate('security_registration_verify', array(
            'email'=> $this->email,
            'activationKey' =>$email->getActivationkey()
        ), true);
        
        
        $client = static::createClient();
        $client->followRedirects(true);
        $crawler = $client->request('GET', $link);
        
        $this->assertTrue($crawler->filter('html:contains("Confirmation")')->count() > 0, $client->getResponse()->getContent());
        
        
        $user = $this->entityManager->getRepository('SecurityAuthenticateBundle:User')->findOneBy(array('email'=>$this->email));
        
        $this->assertTrue(TRUE, $user->getConfirmed());
        
    }
    
    public function testRegistration_confirm_password_fail () 
    {
        $client = static::createClient();
        
        $client->followRedirects(true);
        
        $crawler = $client->request('GET', '/register/');
        
        $form = $crawler->selectButton('_register')->form();
        
        $form['fos_user_registration_form[username]'] = 'test';
        $form['fos_user_registration_form[email]'] = 'test@test.com';
        $form['fos_user_registration_form[plainPassword][first]'] = 'camper';
        $form['fos_user_registration_form[plainPassword][second]'] = 'camperasfasdf';

        $crawler = $client->submit($form);
        
        $this->assertTrue($crawler->filter('html:contains("This value is not valid")')->count() > 0, $client->getResponse()->getContent());
    }
    
    public function testRegistration_email_fail () 
    {
        $client = static::createClient();
        
        $client->followRedirects(true);
        
        $crawler = $client->request('GET', '/register/');
        
        $form = $crawler->selectButton('_register')->form();
        
        $form['fos_user_registration_form[username]'] = 'test';
        $form['fos_user_registration_form[email]'] = 'test@test';
        $form['fos_user_registration_form[plainPassword][first]'] = 'camper';
        $form['fos_user_registration_form[plainPassword][second]'] = 'camper';

        $crawler = $client->submit($form);
        
        $this->assertTrue($crawler->filter('html:contains("The email is not valid")')->count() > 0, $client->getResponse()->getContent());
    }
}
