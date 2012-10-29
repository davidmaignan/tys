<?php


namespace Security\AuthenticateBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;

class ChangePasswordControllerTest extends WebTestCase
{
    /**
     * @var Doctrine\ORM\EntityManager 
     */
    protected $entityManager;
    
    public function setUp()
    {
        
        $kernel = static::createKernel();
        $kernel->boot();
        
        $this->entityManager = $kernel->getContainer()->get('doctrine.orm.entity_manager');
        
    }
    
    public function testChangePassword_success()
    {
        
        $client = static::createClient();
        
        
        $classes = array(
             'Security\AuthenticateBundle\DataFixtures\ORM\UserFixtures',
        );

        $this->loadFixtures($classes);

        $client->followRedirects(true);
        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('_submit')->form();
        $form['_username'] = 'david';
        $form['_password'] = 'camper';

        $crawler = $client->submit($form);
        
        
        $crawler = $client->request('GET', '/profile/change-password');       
        
        $form = $crawler->selectButton('_submit')->form();
        $form['fos_user_change_password_form[current_password]'] = 'camper';
        $form['fos_user_change_password_form[new][first]'] = 'camper2';
        $form['fos_user_change_password_form[new][second]'] = 'camper2';
        //$form['fos_user_change_password_form[_token]'] = 'camper';
        

        $crawler = $client->submit($form);

        $this->assertTrue($crawler->filter('html:contains("The password has been changed")')->count() > 0, $client->getResponse()->getContent());
        
        $this->assertTrue(true,true);
        
    }
    
     public function testChangePassword_wrong_password()
    {
        
        $client = static::createClient();
        
        
        $classes = array(
             'Security\AuthenticateBundle\DataFixtures\ORM\UserFixtures',
        );

        $this->loadFixtures($classes);

        $client->followRedirects(true);
        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('_submit')->form();
        $form['_username'] = 'david';
        $form['_password'] = 'camper';

        $crawler = $client->submit($form);
        
        
        $crawler = $client->request('GET', '/profile/change-password');       
        
        $form = $crawler->selectButton('_submit')->form();
        $form['fos_user_change_password_form[current_password]'] = 'camper2';
        $form['fos_user_change_password_form[new][first]'] = 'camper';
        $form['fos_user_change_password_form[new][second]'] = 'camper';
        //$form['fos_user_change_password_form[_token]'] = 'camper';
        

        $crawler = $client->submit($form);

        $this->assertTrue($crawler->filter('html:contains("This value should be the user current password.")')->count() > 0, $client->getResponse()->getContent());
        
        $this->assertTrue(true,true);
        
    }
    
    public function testChangePassword_mistype_password()
    {
        
        $client = static::createClient();
        
        $classes = array(
             'Security\AuthenticateBundle\DataFixtures\ORM\UserFixtures',
        );

        $this->loadFixtures($classes);

        $client->followRedirects(true);
        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('_submit')->form();
        $form['_username'] = 'david';
        $form['_password'] = 'camper';

        $crawler = $client->submit($form);
        
        
        $crawler = $client->request('GET', '/profile/change-password');       
        
        $form = $crawler->selectButton('_submit')->form();
        $form['fos_user_change_password_form[current_password]'] = 'camper';
        $form['fos_user_change_password_form[new][first]'] = 'camper2';
        $form['fos_user_change_password_form[new][second]'] = 'camper3';        

        $crawler = $client->submit($form);

        $this->assertTrue($crawler->filter('html:contains("Verification")')->count() > 0, $client->getResponse()->getContent());
        
        $this->assertTrue(true,true);
        
    }
    
    
}
