<?php
/**
 * @copyright 2013 Testyrskills Inc.
 */

namespace Behat\BehatBundle\Context;

use Behat\Behat\Context\Step;

use Behat\Gherkin\Node\TableNode;

use Behat\MinkExtension\Context\RawMinkContext;

//
// Require 3rd-party libraries here:
//

/**
 * Date subcontext
 *
 * @author David Maignan <davidmaignan@gmail.com>
 */
class DateContext extends RawMinkContext
{
    // xpath selectors
    private $year;
    private $month;
    private $day;
    private $date;

    /**
     * Resolve day given numeric or magic strings
     *
     * @param mixed $day Day of the month
     *
     * @return mixed
     */
    private function resolveDay($day)
    {
        if ($day === 'current-monthday') {
            return (int) date('d');
        }
        if (ctype_digit($day)) {
            return (int) $day;
        }

        return false;
    }

    /**
     * Resolve month given numeric or magic strings
     *
     * @param mixed $month Month of the year
     *
     * @return mixed
     */
    private function resolveMonth($month)
    {
        if ($month === 'current-month') {
            return (int) date('m');
        }
        if (ctype_digit($month)) {
            return (int) $month;
        }

        return false;
    }

    /**
     * Resolve year given numeric or magic strings
     *
     * @param mixed $year Year
     *
     * @return mixed
     */
    private function resolveYear($year)
    {
        if ($year === 'current-year') {
            return (int) date('Y');
        }
        if (ctype_digit($year)) {
            return (int) $year;
        }

        return false;
    }

    /**
     * Identify the date fields by xpaths
     *
     * @param string    $field Date field
     * @param TableNode $table Optional table
     *
     * @Given /^the date is identified by(?: "([^"]+)"|:)$/
     */
    public function dateIdentifiedBy($field, $table = null)
    {
        if ( ! $table) {
            $this->date = $field;

            return;
        }

        $row = $table->getHash();
        $row = current($row);

        $this->year = $row['year'];
        $this->month = $row['month'];
        $this->day = $row['day'];
        $this->date = null;
    }

    /**
     * Select date (absolute)
     *
     * @param string $year  Year
     * @param string $month Month of the year
     * @param string $day   Day of the month
     *
     * @When /^the date is "([^"]*)" as year, "([^"]*)" as month, and "([^"]*)" as day/
     */
    public function theAbsoluteDateIs($year, $month, $day)
    {
        if ($this->date) {
            $date = sprintf("%04d-%02d-%02d", $this->resolveYear($year), $this->resolveMonth($month), $this->resolveDay($day));
            $step = 'I fill in "' . $this->date . '" with "' . $date . '"';

            return new Step\When($step);
        }

        $this->getSession()->getDriver()->selectOption($this->year, $this->resolveYear($year));
        $this->getSession()->getDriver()->selectOption($this->month, $this->resolveMonth($month));
        $this->getSession()->getDriver()->selectOption($this->day, $this->resolveDay($day));
    }

    /**
     * Select date (relative)
     *
     * @param string $years  Number of years
     * @param string $months Number of months
     * @param string $days   Number of days
     *
     * @When /^the date is "([^"]*)" years?, "([^"]*)" months?, and "([^"]*)" days? ago$/
     */
    public function theRelativeDateIs($years, $months, $days)
    {
        $timestamp = strtotime("$years years $months months $days days ago");

        if ($this->date) {
            $date = date('Y-m-d', $timestamp);
            $step = 'I fill in "' . $this->date . '" with "' . $date . '"';

            return new Step\When($step);
        }

        $this->getSession()->getDriver()->selectOption($this->year, date('Y', $timestamp));
        $this->getSession()->getDriver()->selectOption($this->month, date('n', $timestamp));
        $this->getSession()->getDriver()->selectOption($this->day, date('j', $timestamp));
    }
}
