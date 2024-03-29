<?php
/**
 * @copyright 2013 testyrskills.
 */

namespace Behat\BehatBundle\Context;

use Behat\Behat\Context\Step,
    Behat\Behat\Exception\AmbiguousException;

use Behat\Gherkin\Node\TableNode;

use Behat\MinkExtension\Context\RawMinkContext;

//
// Require 3rd-party libraries here:
//
// require_once 'PHPUnit/Autoload.php';
// require_once 'PHPUnit/Framework/Assert/Functions.php';

/**
 * Queue step subcontext
 *
 * @author David Maignan <davidmaignan@gmail.com>
 */
class QueueStepContext extends RawMinkContext
{
    /*
     * @var array Queued steps
     */
    private $steps = array();

    /**
     * I will (be) ...
     *
     * @param string    $be    "be" (or '' if not present)
     * @param string    $step  Step text
     * @param TableNode $table Optional table
     *
     * @return array|void
     *
     * @Given /^(?:|I )will (be )?(.*)$/
     */
    public function iWill($be, $step, $table = null)
    {
        $foreach = substr($step, -10) === ' for each:';

        if (($table && !$foreach) || (!$table && $foreach)) {
            throw new AmbiguousException("I will (be) $step", array());
        }

        if ($foreach) {
            $step = substr($step, 0, -10);
        }

        $this->steps[] = strlen($be) ? "I am $step" : "I $step";

        if ($table) {
            return $this->doItForEach($table);
        }
    }

    /**
     * I should later (also) ...
     *
     * @param string    $step  Step text
     * @param TableNode $table Optional table
     *
     * @return array|void
     *
     * @Given /^(?:|I )should later (?:also )?(.*)$/
     */
    public function iShouldLater($step, $table = null)
    {
        $foreach = substr($step, -10) === ' for each:';

        if (($table && !$foreach) || (!$table && $foreach)) {
            throw new AmbiguousException("I should later (also) $step", array());
        }

        if ($foreach) {
            $step = substr($step, 0, -10);
        }

        $this->steps[] = "I should $step";

        if ($table) {
            return $this->doItForEach($table);
        }
    }

    /**
     * Do it for each:
     *
     * @param TableNode $table
     *
     * @return array
     *
     * @Then /^do (?:it|so) for each:$/
     */
    public function doItForEach($table)
    {
        $steps = array();

        $situations = $table->getHash();
        foreach ($situations as $situation) {
            foreach ($this->steps as $step) {
                if (preg_match_all('/(\{[^}]+\})/', $step, $matches)) {
                    foreach ($matches[0] as $key) {
                        $nakedKey = substr($key, 1, -1);
                        if (isset($situation[$nakedKey])) {
                            $step = str_replace($key, $situation[$nakedKey], $step);
                        }
                    }
                }

                $steps[] = new Step\Then($step);
            }
        }

        $this->steps = array();

        return $steps;
    }
}
