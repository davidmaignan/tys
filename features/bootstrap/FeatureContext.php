<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

use Acme\DemoBundle\Entity\Product;
use Acme\DemoBundle\Entity\Category;

//
// Require 3rd-party libraries here:
//
   require_once 'PHPUnit/Autoload.php';
   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Features context.
 */
class FeatureContext extends BehatContext
{
    /**
     * Initializes context.
     * Every scenario gets it's own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters)
    {
        // Initialize your context here
    }

//
// Place your definition and hook methods here:
//
//    /**
//     * @Given /^I have done something with "([^"]*)"$/
//     */
//    public function iHaveDoneSomethingWith($argument)
//    {
//        doSomethingWith($argument);
//    }
//
    
    /**
     * @Given /I have a category "([^"]*)"/ 
     */
    public function iHaveACategory($name)
    {
        $category = new \Acme\DemoBundle\Entity\Category();
        $category->setName($name);
        $this->getEntityManager()->persist($category);
        $this->getEntityManager()->flush();
        
    }
    
    /**
     * @Given /I have a product "([^"]*)"/ 
     */
    public function iHaveAProduct($name)
    {
        $product = new \Acme\DemoBundle\Entity\Product();
        $product->setName($name);
        
        $this->getEntityManager()->persist($product);
        $this->getEntityManager()->flush();
    }
    
    /**
     * Returns the Doctrine entity manager
     * 
     * @return Doctrine\ORM\EntityManager 
     */
    protected function getEntityManager()
    {
        return $this->getContainer()->get('doctrine')->getEntityManager();
    }
    
}
