<?php

namespace Security\AuthenticateBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegistrationControllerTest extends WebTestCase
{
    public function testRegistration_successful () 
    {
        $client = static::createClient();
        
        $client->followRedirects(true);
        
        $crawler = $client->request('GET', '/register/');
        
        $form = $crawler->selectButton('_register')->form();
        
        $form['fos_user_registration_form[username]'] = 'afadsfasdf';
        $form['fos_user_registration_form[email]'] = 'teadsfasdfasst@test.com';
        $form['fos_user_registration_form[plainPassword][first]'] = 'camper';
        $form['fos_user_registration_form[plainPassword][second]'] = 'camper';

        $crawler = $client->submit($form);
        
        $this->assertTrue($crawler->filter('html:contains("Congrats")')->count() > 0, $client->getResponse()->getContent());
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
