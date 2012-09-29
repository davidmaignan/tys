<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

//
// Require 3rd-party libraries here:
//
//   require_once 'PHPUnit/Autoload.php';
//   require_once 'PHPUnit/Framework/Assert/Functions.php';
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
        var_dump($parameters);
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
     * @Given /^I have a category "([^"]*)"$/
     */
    public function iHaveACategory($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Given /^I have a product "([^"]*)"$/
     */
    public function iHaveAProduct($arg1)
    {
        throw new PendingException();
    }

    /**
     * @When /^I add product "([^"]*)" to category "([^"]*)"$/
     */
    public function iAddProductToCategory($arg1, $arg2)
    {
        throw new PendingException();
    }

    /**
     * @Then /^I should find product "([^"]*)" in category "([^"]*)"$/
     */
    public function iShouldFindProductInCategory($arg1, $arg2)
    {
        throw new PendingException();
    }

}
