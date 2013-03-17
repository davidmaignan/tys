<?php
/**
 * @copyright 2013 testyrskills.com
 */

namespace Behat\BehatBundle\Context;

use Behat\MinkExtension\Context\RawMinkContext;

//
// Require 3rd-party libraries here:
//

/**
 * Birthdate subcontext
 *
 * @author David Maignan <davidmaignan@gmail.com>
 */
class CookieContext extends RawMinkContext
{
    /**
     * @var array Local cookie store
     */
    private $cookies = array();

    /**
     * Save the named cookie
     *
     * @param string $name Cookie name
     *
     * @When /^(?:|I )save my "([^"]*)" cookie$/
     */
    public function saveCookie($name)
    {
        $value = $this->getSession()->getCookie($name);

        $this->cookies[$name] = $value;
    }

    /**
     * Load page (if necessary) and set cookie
     *
     * @param string $name  Cookie name
     * @param string $value Cookie value
     *
     * @internal
     */
    private function sendCookie($name, $value)
    {
        $currentUrl = $this->getSession()->getCurrentUrl();

        if ($currentUrl === 'about:blank') {
            $this->getMainContext()->visit('/');
        }

        $this->getSession()->setCookie($name, $value);
    }

    /**
     * Restore the named cookie
     *
     * @param string $name Cookie name
     *
     * @When /^(?:|I )restore my "([^"]*)" cookie$/
     */
    public function restoreCookie($name)
    {
        $this->sendCookie($name, $this->cookies[$name]);
    }

    /**
     * Set cookie to specified value
     *
     * @param string $name  Cookie name
     * @param string $value Cookie value
     *
     * @When /^(?:|I )set my "([^"]*)" cookie to "([^"]*)"$/
     */
    public function setCookie($name, $value)
    {
        $this->sendCookie($name, $value);
    }
}
