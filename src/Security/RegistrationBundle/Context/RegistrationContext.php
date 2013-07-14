<?php

/*
 * This file is part of the CoreAnswerBundle package.
 *
 * (c) Testyrskills.com <http://www.Testyrskills.com/>
 *
 */

namespace Security\RegistrationBundle\Context;

use Behat\MinkExtension\Context\MinkContext;
use Behat\Gherkin\Node\TableNode;
use Behat\Symfony2Extension\Context\KernelAwareInterface;
use Symfony\Component\HttpKernel\KernelInterface;

use Symfony\Component\Security\Core\User\InMemoryUserProvider;
use Symfony\Component\Security\Core\User\UserChecker;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Symfony\Component\Security\Core\Authentication\Provider\AnonymousAuthenticationProvider;
use Symfony\Component\Security\Core\Authentication\Provider\DaoAuthenticationProvider;
use Symfony\Component\Security\Core\Authentication\AuthenticationProviderManager;

use Symfony\Component\Security\Core\Authorization\Voter\Rolevoter;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManager;

use Symfony\Component\Security\Core\SecurityContext;

use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Exception\ProviderNotFoundException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;  

use Security\AuthenticateBundle\Entity\User;;

//
// Require 3rd-party libraries here:
//
require_once 'PHPUnit/Autoload.php';
require_once 'PHPUnit/Framework/Assert/Functions.php';

/*
 * @author David Maignan <davidmaignan@gmail.com>
 */
class RegistrationContext extends MinkContext implements KernelAwareInterface
{
    /**
     * @var KernelInterface Kernel
     */
    private $kernel;

    /**
     * @var array
     */
    private $dictionary = array();

    /**
     * {@inheritdoc}
     */
    public function setKernel(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }
    
    /**
     * Get service from container
     *
     * @param string $serviceName Service name
     *
     * @return mixed
     */
    private function getService($serviceName)
    {
        return $this->kernel->getContainer()->get($serviceName);
    }
    
    /**
     * Create user(s) from a table.  
     *
     * Example:
     *   Given the following users exist:
     *     | login | password | screenName |
     *
     * @Given /^the following activated user exists:$/
     * 
     * @param TableNode $table     Data set
     *
     */
    public function registerUsers(TableNode $table) 
    {
        //Retrieve resgistration service
        $userManager = $this->getService('fos_user.user_manager');
        
        $hash = $table->getHash();
        
        foreach ($hash as $row) {
            
            $user = $userManager->findUserBy(array('email'=>$row['login']));
            
            if($user){
                continue;
            }
            
            
            $user =  $userManager->createUser();
            $user->setUsername($row['screenName']);
            $user->setEmail($row['login']);
            $user->setEnabled(true);
            $user->setRoles(array($row['role']));

            $encoder = $this->getService('security.encoder_factory')->getEncoder($user);
            $user->setPassword($encoder->encodePassword($row['password'], $user->getSalt()));

            $userManager->updateUser($user);
        }
        
        
    }  
    
    /**
     * Login user from an email
     * 
     * @When /^I am logged in as "([^"]*)" with "([^"]*)"$/
     */
    public function autoLogin($username, $password)
    {       
        //http://sirprize.me/scribble/under-the-hood-of-symfony-security/
       
        //User Manager service
        $userManager = $this->getService('fos_user.user_manager');
        $user = $userManager->createUser();
        $passwordEncoder = $this->getService('security.encoder_factory')->getEncoder($user); 
        
        $anonymousKey = uniqid();
        $inMemoryUserProvider = new InMemoryUserProvider();
        $userChecker = new UserChecker();  
        
        $encoderFactory = new EncoderFactory(array(
            'Security\AuthenticateBundle\Entity\User' => $passwordEncoder
        )); 
        
        $authenticationProviders = array(
            // validates AnonymousToken instances
            new AnonymousAuthenticationProvider($anonymousKey),
            // retrieve the user for a UsernamePasswordToken
            new DaoAuthenticationProvider($inMemoryUserProvider, $userChecker, 'main', $encoderFactory)
        );

        $authenticationManager = new AuthenticationProviderManager($authenticationProviders);
        
        $voters = array(
            // votes if any attribute starts with a given prefix
            new Rolevoter('ROLE_')
        );

        $accessDecisionManager = new AccessDecisionManager($voters);
        
        $securityContext = new SecurityContext($authenticationManager, $accessDecisionManager);
                        
        try {
            
            $usernamePasswordToken = new UsernamePasswordToken($username, $password, 'main');
            $authenticationManager->authenticate($usernamePasswordToken);
            $securityContext->setToken($usernamePasswordToken); 

            if ($securityContext->isGranted('ROLE_ADMIN')) {
                die('Access granted');
            } else {
                die('Access denied');
            }
        } catch (BadCredentialsException $e) {
            die('Invalid username or password');
        } catch (ProviderNotFoundException $e) {
            die('Provider could not be found');
        }
        
        //var_dump($securityContext, $username, $password);
        exit;
    }
    
    /**
     * Get credential by email address
     *
     * @param string $email Email address
     *
     * @return \IC\Bundle\Core\SecurityBundle\Entity\Credential
     */
    private function getCredentialByEmail($email)
    {
        $email = function_exists('mb_strtolower') ? mb_strtolower($email, 'UTF-8') : strtolower($email);

        $userManager = $this->getService('fos_user.user_manager');
        
        $user = $userManager->findUserBy(array('email'=>$email));

        return $user;
    }


}