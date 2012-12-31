<?php

namespace Security\AuthenticateBundle\Tests\Controller;

//use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use Liip\FunctionalTestBundle\Test\WebTestCase;

class LoginControllerTest extends WebTestCase
{
    
    
    public function testAuthenticateLogin_goodLogin() {
        $client = static::createClient();
        
        $classes = array(
             'Security\AuthenticateBundle\DataFixtures\ORM\UserFixtures',
        );

        $this->loadFixtures($classes);

        $client->followRedirects(true);
        $crawler = $client->request('GET', '/');

        $form = $crawler->selectButton('loginBtn')->form();
        $form['_username'] = 'user';
        $form['_password'] = 'userpass';

        $crawler = $client->submit($form);

        $this->assertTrue($crawler->filter('html:contains("Logged in as")')->count() > 0, $client->getResponse()->getContent());
    }
    
    public function testAuthenticationLogin_badLogin(){
        $client = static::createClient();
        
        $client->followRedirects(true);
        $crawler = $client->request('GET','/');
        $form = $crawler->selectButton('loginBtn')->form();
        $form['_username'] = 'user';
        $form['_password'] = 'camper242?';
        $crawler = $client->submit($form);
        
        $this->assertTrue($crawler->filter('html:contains("Invalid username or password")')->count() > 0, $client->getResponse()->getContent());
        
        
        
    }
}
