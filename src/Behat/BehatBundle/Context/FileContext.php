<?php
/**
 * @copyright 2013 testyrskills.com
 */

namespace Behat\BehatBundle\Context;

use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

use Behat\MinkExtension\Context\RawMinkContext;

//
// Require 3rd-party libraries here:
//
// require_once 'PHPUnit/Autoload.php';
// require_once 'PHPUnit/Framework/Assert/Functions.php';

/**
 * Adapted from Behat test suite context.
 *
 * @author David Maignan <davidmaignan@gmail.com>
 */
class FileContext extends RawMinkContext
{
    /**
     * Environment variable
     *
     * @var string
     */
    private $env;

    /**
     * Last ran command name.
     *
     * @var string
     */
    private $command;

    /**
     * Last ran command output.
     *
     * @var string
     */
    private $output;

    /**
     * Last ran command return code.
     *
     * @var integer
     */
    private $return;

    /**
     * Creates a file with specified name and context in current workdir.
     *
     * @param string                          $filename name of the file (relative path)
     * @param Behat\Gherkin\Node\PyStringNode $content  PyString string instance
     *
     * @Given /^(?:there is )?a file named "([^"]*)" with:$/
     */
    public function aFileNamedWith($filename, PyStringNode $content)
    {
        $content = strtr((string) $content, array("'''" => '"""'));

        file_put_contents($filename, $content);
    }

    /**
     * Moves user to the specified path.
     *
     * @param string $path
     *
     * @Given /^I am in the "([^"]*)" path$/
     */
    public function iAmInThePath($path)
    {
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        chdir($path);
    }

    /**
     * Checks whether a file at provided path exists.
     *
     * @param string $path
     *
     * @Given /^file "([^"]*)" should exist$/
     */
    public function fileShouldExist($path)
    {
        assertFileExists(getcwd() . DIRECTORY_SEPARATOR . $path);
    }

    /**
     * Sets specified ENV variable
     *
     * @param PyStringNode $value
     *
     * @When /^"BEHAT_PARAMS" environment variable is set to:$/
     */
    public function iSetEnvironmentVariable(PyStringNode $value)
    {
        $this->env = (string) $value;
    }

    /**
     * Runs behat command with provided parameters
     *
     * @param string $argumentsString
     *
     * @When /^I run "behat(?: ([^"]*))?"$/
     */
    public function iRunBehat($argumentsString = '')
    {
        $argumentsString = strtr($argumentsString, array('\'' => '"'));

        if ('/' === DIRECTORY_SEPARATOR) {
            $argumentsString .= ' 2>&1';
        }

        $commandFormat = $this->env ? 'BEHAT_PARAMS="%s" %s %s %s' : '%.0s%s %s %s --no-time';

        exec($command = sprintf($commandFormat,
            $this->env, BEHAT_PHP_BIN_PATH, escapeshellarg(BEHAT_BIN_PATH), $argumentsString
        ), $output, $return);

        $this->command = 'behat ' . $argumentsString;
        $this->output  = trim(implode("\n", $output));
        $this->return  = $return;
    }

    /**
     * Checks whether previously runned command passes|failes with provided output.
     *
     * @param string                          $success "fail" or "pass"
     * @param Behat\Gherkin\Node\PyStringNode $text    PyString text instance
     *
     * @return void
     *
     * @Then /^it should (fail|pass) with:$/
     */
    public function itShouldPassWith($success, PyStringNode $text)
    {
        switch ($success) {
            case 'fail':
                assertNotEquals(0, $this->return);
                break;

            default:
                assertEquals(0, $this->return);
        }

        $text = strtr($text, array('\'\'\'' => '"""', '%PATH%' => realpath(getcwd())));

        // windows path fix
        if ('/' !== DIRECTORY_SEPARATOR) {
            $text = preg_replace_callback('/ features\/[^\n ]+/', function($matches) {
                return str_replace('/', DIRECTORY_SEPARATOR, $matches[0]);
            }, (string) $text);
            $text = preg_replace_callback('/\<span class\="path"\>features\/[^\<]+/', function($matches) {
                return str_replace('/', DIRECTORY_SEPARATOR, $matches[0]);
            }, (string) $text);
            $text = preg_replace_callback('/\+[fd] [^ ]+/', function($matches) {
                return str_replace('/', DIRECTORY_SEPARATOR, $matches[0]);
            }, (string) $text);
        }

        try {
            assertEquals((string) $text, $this->output);
        } catch (Exception $e) {
            $diff = PHPUnit_Framework_TestFailure::exceptionToString($e);
            throw new Exception($diff, $e->getCode(), $e);
        }
    }

    /**
     * Checks whether specified file exists and contains specified string.
     *
     * @param string                          $path file path
     * @param Behat\Gherkin\Node\PyStringNode $text file content
     *
     * @Given /^"([^"]*)" file should contain:$/
     */
    public function fileShouldContain($path, PyStringNode $text)
    {
        try {
            assertFileExists($path);
            assertEquals((string) $text, trim(file_get_contents($path)));
        } catch (Exception $e) {
            $diff = PHPUnit_Framework_TestFailure::exceptionToString($e);
            throw new Exception($diff, $e->getCode(), $e);
        }
    }

    /**
     * Checks whether specified file exists and has the expected hash value.
     *
     * @param string $filePath  file path
     * @param string $algorithm hash algorithm
     * @param string $hashValue file's hash value
     *
     * @Then /^"([^"]*)" file's "([^"]*)" hash should be "([^"]*)"$/
     */
    public function fileHashShouldBe($filePath, $algorithm, $hashValue)
    {
        try {
            assertFileExists($filePath);
        } catch (Exception $e) {
            $diff = PHPUnit_Framework_TestFailure::exceptionToString($e);
            throw new Exception($diff, $e->getCode(), $e);
        }

        if ($hashValue != hash_file($algorithm, $filePath)) {
            throw new \Exception('Failed asserting the file\'s integrity. The file\'s actual hash code is "' . hash_file($algorithm, $filePath) . '".');
        }
    }

    /**
     * Prints last command output string.
     *
     * @Then display last command output
     */
    public function displayLastCommandOutput()
    {
        $this->printDebug("`" . $this->command . "`:\n" . $this->output);
    }

    /**
     * Checks whether last command output contains provided string.
     *
     * @param Behat\Gherkin\Node\PyStringNode $text PyString text instance
     *
     * @return void
     *
     * @Then the output should contain:
     */
    public function theOutputShouldContain(PyStringNode $text)
    {
        $text = strtr($text, array('\'\'\'' => '"""', '%PATH%' => realpath(getcwd())));

        // windows path fix
        if ('/' !== DIRECTORY_SEPARATOR) {
            $text = preg_replace_callback('/ features\/[^\n ]+/', function($matches) {
                return str_replace('/', DIRECTORY_SEPARATOR, $matches[0]);
            }, (string) $text);
            $text = preg_replace_callback('/\<span class\="path"\>features\/[^\<]+/', function($matches) {
                return str_replace('/', DIRECTORY_SEPARATOR, $matches[0]);
            }, (string) $text);
            $text = preg_replace_callback('/\+[fd] [^ ]+/', function($matches) {
                return str_replace('/', DIRECTORY_SEPARATOR, $matches[0]);
            }, (string) $text);
        }

        try {
            assertContains((string) $text, $this->output);
        } catch (Exception $e) {
            $diff = PHPUnit_Framework_TestFailure::exceptionToString($e);
            throw new Exception($diff, $e->getCode(), $e);
        }
    }

    /**
     * Checks whether previously runned command failed|passed.
     *
     * @param string $success "fail" or "pass"
     *
     * @Then /^it should (fail|pass)$/
     */
    public function itShouldFail($success)
    {
        switch ($success) {
            case 'fail':
                assertNotEquals(0, $this->return);
                break;

            default:
                assertEquals(0, $this->return);
        }
    }
}
