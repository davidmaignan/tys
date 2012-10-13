<?php

namespace Security\AuthenticateBundle\Tests;

use Liip\FunctionalTestBundle\Test\WebTestCase;

class ResettingControllerTest extends WebTestCase
{
    
    public function testSendEmailAction()
    {
        
        $client = static::createClient();
        $client->followRedirects(true);
        
        $crawler = $client->request('GET', '/resetting/request');
        
        $form = $crawler->selectButton('_submit_resetting')->form();
        
        $form['username'] = 'david';
        
        $crawler = $client->submit($form);
        
        $response = $client->getResponse()->getContent();
        
        $this->assertTrue($crawler->filter('html:contains("It contains a link you must click to reset your password")')->count() > 0, $response);
        
    }
    
    public function testSendEmail_Wrong_Username()
    {
        $client = static::createClient();
        $client->followRedirects(true);
        
        $crawler = $client->request('GET', '/resetting/request');
        
        $form = $crawler->selectButton('_submit_resetting')->form();
        
        $form['username'] = 'david242';
        
        $crawler = $client->submit($form);
        
        $response = $client->getResponse()->getContent();
        
        $this->assertTrue($crawler->filter('html:contains("does not exist.")')->count() > 0, $response);
        
    }
    
    public function testSendEmail_Already_Requested()
    {
        
        $client = static::createClient();
        $client->followRedirects(true);
        
        $crawler = $client->request('GET', '/resetting/request');
        
        $form = $crawler->selectButton('_submit_resetting')->form();
        
        $form['username'] = 'david';
        
        $crawler = $client->submit($form);
        
        $response = $client->getResponse()->getContent();
        
        $this->assertTrue($crawler->filter('html:contains("The password for this user has already been requested within the last 24 hours.")')->count() > 0, $response);
    }
    
}
