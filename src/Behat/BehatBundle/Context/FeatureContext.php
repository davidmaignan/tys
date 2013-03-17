<?php
/**
 * @copyright 2012 Instaclick Inc.
 */

namespace Behat\BehatBundle\Context;

use Behat\MinkExtension\Context\MinkContext;

//
// Require 3rd-party libraries here:
//
require_once 'PHPUnit/Autoload.php';
require_once 'PHPUnit/Framework/Assert/Functions.php';

/**
 * Main Feature Context
 *
 * This class overrides "steps" defined in MinkContext.
 * Application-specific "steps" are defined in subcontexts and loaded via the ContextInitializer extension.
 *
 * @author Yuan Xie <shayx@nationalfibre.net>
 * @author Anthon Pang <anthonp@nationalfibre.net>
 */
class FeatureContext extends RawMinkContext
{
    /**
     * {@inheritdoc}
     */
    public function fillField($field, $value)
    {
        $this->getSession()->getSelectorsHandler()->getSelector('named')->registerNamedXpath(
            'field',
            ".//*[self::input | self::textarea | self::select][not(./@type = 'submit' or ./@type = 'image' or ./@type = 'hidden')][(((./@id = %locator% or ./@name = %locator%) or ./@id = //label[contains(normalize-space(string(.)), %locator%)]/@for) or ./@placeholder = %locator%)] | .//label[contains(normalize-space(string(.)), %locator%)]//.//*[self::input | self::textarea | self::select][not(./@type = 'submit' or ./@type = 'image' or ./@type = 'hidden')] | .//label[contains(normalize-space(string(.)), %locator%)]/../div/div/*[self::input | self::textarea | self::select][not(./@type = 'submit' or ./@type = 'image' or ./@type = 'hidden')]"
        );

        parent::fillField($field, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function checkOption($option)
    {
        // override selector to handle twitter-bootstrap style checkbox+label layout (and <span> variant)
        $this->getSession()->getSelectorsHandler()->getSelector('named')->registerNamedXpath(
            'checkbox',
            ".//input[./@type = 'checkbox'][(((./@id = %locator% or ./@name = %locator%) or ./@id = //label[contains(normalize-space(string(.)), %locator%)]/@for) or ./@placeholder = %locator%)] | .//label[contains(normalize-space(string(.)), %locator%)]//.//input[./@type = 'checkbox'] | .//div/label[contains(normalize-space(string(.)), %locator%)]/../input[./@type = 'checkbox'] | .//span/label[contains(normalize-space(string(.)), %locator%)]/../input[./@type = 'checkbox']"
        );

        parent::checkOption($option);
    }

    /**
     * {@inheritdoc}
     */
    public function uncheckOption($option)
    {
        // override selector to handle twitter-bootstrap style checkbox+label layout (and <span> variant)
        $this->getSession()->getSelectorsHandler()->getSelector('named')->registerNamedXpath(
            'checkbox',
            ".//input[./@type = 'checkbox'][(((./@id = %locator% or ./@name = %locator%) or ./@id = //label[contains(normalize-space(string(.)), %locator%)]/@for) or ./@placeholder = %locator%)] | .//label[contains(normalize-space(string(.)), %locator%)]//.//input[./@type = 'checkbox'] | .//div/label[contains(normalize-space(string(.)), %locator%)]/../input[./@type = 'checkbox'] | .//span/label[contains(normalize-space(string(.)), %locator%)]/../input[./@type = 'checkbox']"
        );

        parent::uncheckOption($option);
    }

    /**
     * {@inheritdoc}
     */
    public function selectOption($select, $option)
    {
        // TODO: decouple
        if ($select === 'Gender') {
            $option = $this->getSubcontext('SelectContext')->getOptionValue($option);
        }

        $this->getSession()->getSelectorsHandler()->getSelector('named')->registerNamedXpath(
            'select',
            ".//select[(((./@id = %locator% or ./@name = %locator%) or ./@id = //label[contains(normalize-space(string(.)), %locator%)]/@for) or ./@placeholder = %locator%)] | .//label[contains(normalize-space(string(.)), %locator%)]//.//select | .//div/label[contains(text(), %locator%)]/../select"
        );

        parent::selectOption($select, $option);
    }

    /**
     * {@inheritdoc}
     */
    public function additionallySelectOption($select, $option)
    {
        $this->selectOption($select, $option);
    }

    /**
     * {@inheritdoc}
     */
    public function assertFieldContains($field, $value)
    {
        $this->getSession()->getSelectorsHandler()->getSelector('named')->registerNamedXpath(
            'field',
            ".//*[self::input | self::textarea | self::select][not(./@type = 'submit' or ./@type = 'image' or ./@type = 'hidden')][(((./@id = %locator% or ./@name = %locator%) or ./@id = //label[contains(normalize-space(string(.)), %locator%)]/@for) or ./@placeholder = %locator%)] | .//label[contains(normalize-space(string(.)), %locator%)]//.//*[self::input | self::textarea | self::select][not(./@type = 'submit' or ./@type = 'image' or ./@type = 'hidden')] | .//label[contains(normalize-space(string(.)), %locator%)]/../div/div/*[self::input | self::textarea | self::select][not(./@type = 'submit' or ./@type = 'image' or ./@type = 'hidden')]"
        );

        parent::assertFieldContains($field, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function assertPageContainsText($text)
    {
        $expected = str_replace('\\"', '"', $text);
        $actual   = $this->getSession()->getPage()->getText();
        if (strpos($actual, $expected) === false) {
            var_dump($actual);
        }

        parent::assertPageContainsText($text);
    }

    /**
     * {@inheritdoc}
     */
    public function assertPageAddress($address)
    {
        $expectedUrl = $this->locatePath($address);
        if ($expectedUrl !== $this->getSession()->getCurrentUrl()) {
            var_dump(array($address, $expectedUrl, $this->getSession()->getCurrentUrl(), $this->getSession()->getDriver()->getContent()));
        }

        parent::assertPageAddress($address);
    }

    /**
     * {@inheritdoc}
     */
    public function assertCheckboxChecked($checkbox)
    {
        // override selector to handle twitter-bootstrap style checkbox+label layout (and <span> variant)
        $this->getSession()->getSelectorsHandler()->getSelector('named')->registerNamedXpath(
            'checkbox',
            ".//input[./@type = 'checkbox'][(((./@id = %locator% or ./@name = %locator%) or ./@id = //label[contains(normalize-space(string(.)), %locator%)]/@for) or ./@placeholder = %locator%)] | .//label[contains(normalize-space(string(.)), %locator%)]//.//input[./@type = 'checkbox'] | .//div/label[contains(normalize-space(string(.)), %locator%)]/../input[./@type = 'checkbox'] | .//span/label[contains(normalize-space(string(.)), %locator%)]/../input[./@type = 'checkbox']"
        );

        parent::assertCheckboxChecked($checkbox);
    }

    /**
     * {@inheritdoc}
     */
    public function assertCheckboxNotChecked($checkbox)
    {
        // override selector to handle twitter-bootstrap style checkbox+label layout (and <span> variant)
        $this->getSession()->getSelectorsHandler()->getSelector('named')->registerNamedXpath(
            'checkbox',
            ".//input[./@type = 'checkbox'][(((./@id = %locator% or ./@name = %locator%) or ./@id = //label[contains(normalize-space(string(.)), %locator%)]/@for) or ./@placeholder = %locator%)] | .//label[contains(normalize-space(string(.)), %locator%)]//.//input[./@type = 'checkbox'] | .//div/label[contains(normalize-space(string(.)), %locator%)]/../input[./@type = 'checkbox'] | .//span/label[contains(normalize-space(string(.)), %locator%)]/../input[./@type = 'checkbox']"
        );

        parent::assertCheckboxNotChecked($checkbox);
    }

    /**
     * {@inheritdoc}
     */
    public function visit($page)
    {
        // TODO: decouple
        $this->getSubcontext('CredentialContext')->visitWithPropertySubstitution($page);
    }

    /**
     * {@inheritdoc}
     */
    public function locatePath($path)
    {
        return parent::locatePath($path);
    }
}
