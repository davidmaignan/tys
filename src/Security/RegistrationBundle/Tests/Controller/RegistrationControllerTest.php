<?php

namespace Security\RegistrationBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testRegistration_successful () 
    {
        $client = static::createClient();
        
        $client->followRedirects(true);
        
        $crawler = $client->request('GET', '/register/');
        
        $form = $crawler->selectButton('_register')->form();
        
        $form['fos_user_registration_form[username]'] = 'afadsfasdffdgfgd';
        $form['fos_user_registration_form[email]'] = 'teadsfasdfasstfgd@test.com';
        $form['fos_user_registration_form[plainPassword][first]'] = 'camper';
        $form['fos_user_registration_form[plainPassword][second]'] = 'camper';

        $crawler = $client->submit($form);
        
        $this->assertTrue($crawler->filter('html:contains("Congratulations")')->count() > 0, $client->getResponse()->getContent());
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
