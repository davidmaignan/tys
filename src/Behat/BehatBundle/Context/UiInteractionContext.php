<?php
/**
 * @copyright 2012 Instaclick Inc.
 */

namespace Behat\BehatBundle\Context;

use Behat\MinkExtension\Context\RawMinkContext;

//
// Require 3rd-party libraries here:
//

/**
 * Ui Interaction subcontext
 *
 * @author Yuan Xie <shayx@nationalfibre.net>
 */
class UiInteractionContext extends RawMinkContext
{
    /**
     * Attach a file to a field by a given id
     *
     * @param string $path           File path
     * @param string $fieldElementId The id for the target field
     *
     * @When /^(?:|I )attach a file at "([^"]*)" path to "([^"]*)"$/
     */
    public function attachAFileToField($path, $fieldElementId)
    {
        $this->getMainContext()->attachFileToField($fieldElementId, realpath($path));

        $assertFileAlreadyInInputHelperJavaScript = <<<JS
            var inputHelper = document.getElementById('$fieldElementId');
            if (inputHelper.files.length != 1) {
                return false;
            }

            return true;
JS;
        $this->assertByJavaScript(
            $assertFileAlreadyInInputHelperJavaScript,
            'The file was NOT successfully set into the helper with id="' . $fieldElementId . '".'
        );
    }

    /**
     * Drop a file or a directory of files to the page
     *
     * @param string $path File or directory path
     *
     * @When /^(?:|I )drop (?:|a )file(?:|s) at "([^"]*)" path to the page$/
     */
    public function dropFilesToPage($path)
    {
        $elementFinder = "body";
        $this->dropFilesToElement($path, $elementFinder);
    }

    /**
     * Drop a file or a directory of files to a target element by id
     *
     * @param string $path      File or directory path
     * @param string $elementId Target element id
     *
     * @When /^(?:|I )drop (?:|a )file(?:|s) at "([^"]*)" path to "([^"]*)"$/
     */
    public function dropFilesToElementById($path, $elementId)
    {
        $this->elementShouldExist($elementId);

        $elementFinder = 'getElementById("' . $elementId . '")';
        $this->dropFilesToElement($path, $elementFinder);
    }

    /**
     * Drop a file or a directory of files to a target element
     *
     * @param string $path          File or directory path
     * @param string $elementFinder The JavaScript which is used for finding the drop-target element
     */
    protected function dropFilesToElement($path, $elementFinder)
    {
        // Step 1. a) Create a variable by $fileListVariableName name
        //         b) AppendChild the variable to body
        //         c) Assert the variable exists
        $fileListVariableName = $this->insertArrayVariable();

        // Step 2. a) Collect the list of file paths from the give $path
        $filePathList = $this->collectFileList($path);

        // Step 3. a) Create a <input id="$inputHelperElementId" type="file" multiple="multiple" />
        //         b) AppendChild this <input> helper to body
        //         c) Assert the helper exists
        //         d) For each file in the $filePathList
        //            i)  Create the File object inside of the <input> helper
        //            ii) Move the helper's new File object to the FileList variable's holdings
        //         e) Delete the <input> helper from the DOM
        //         f) Assert <input> helper no longer exists
        //         g) Assert FileList variable has all the files
        $this->loadFileListToScriptVariable($filePathList, $fileListVariableName);

        // Step 4. a) Create an event
        //         b) Mocking the event.dataTransfer object
        //         c) Mocking the event.dataTransfer.files object using FileList variable
        //         d) Using this newly-created event object, trigger the "drop" event
        $this->triggerDropEvent($fileListVariableName, $elementFinder);
    }

    /**
     * Insert an array variable
     *
     * @return string $name The name of the variable
     */
    protected function insertArrayVariable()
    {
        $name = 'arrayVariable' . rand(5, 5);
        $insertArrayVariableJavaScript = <<<JS
            var variableScript   = document.createElement('script');
            var variableTextNode = document.createTextNode('var $name = [];');
            variableScript.appendChild(variableTextNode);
            document.body.appendChild(variableScript);
JS;
        $this->getSession()->executeScript($insertArrayVariableJavaScript);

        $assertVariableExistJavaScript = <<<JS
            return typeof $name != 'undefined';
JS;
        $this->assertByJavaScript(
            $assertVariableExistJavaScript,
            'The variable named "' . $name . ' was NOT successfully defined.'
        );

        return $name;
    }

    /**
     * Insert a <input type="file" multiple="multiple"> element into the page by a given element ID
     *
     * @param string $elementId The id for <input type="file" multiple="multiple">
     */
    protected function insertInputFileElement($elementId)
    {
        $inputFileInjectionJavaScript = <<<JS
            var inputElement = document.createElement('input');
            inputElement.setAttribute('id', '$elementId');
            inputElement.setAttribute('type', 'file');
            inputElement.setAttribute('multiple', 'multiple');

            document.body.appendChild(inputElement);
JS;
        $this->getSession()->executeScript($inputFileInjectionJavaScript);

        $assertInputFileExistJavaScript = <<<JS
            if (! document.getElementById('$elementId')) {
                return false;
            }

            return true;
JS;
        $this->assertByJavaScript(
            $assertInputFileExistJavaScript,
            'The <input> element with id="' . $elementId . ' was NOT successfully added.'
        );
    }

    /**
     * Add a list of files to a JavaScript variable by a given id
     *
     * @param string $filePathList A list of absolute paths of files
     * @param string $variableName The name of the array variable which holds the loaded File objects
     */
    protected function loadFileListToScriptVariable($filePathList, $variableName)
    {
        $inputHelperElementId = 'drag_and_drop_test_input_helper';
        $this->insertInputFileElement($inputHelperElementId);

        foreach ($filePathList as $filePath) {
            $this->loadFileToScriptVariable($filePath, $inputHelperElementId, $variableName);
        }

        $this->removeElementById($inputHelperElementId);

        $fileCount = count($filePathList);
        $assertFileListAlreadyInInputHelperJavaScript = <<<JS
            if ($variableName.length != $fileCount) {
                return false;
            }

            return true;
JS;
        $this->assertByJavaScript(
            $assertFileListAlreadyInInputHelperJavaScript,
            'The file(s) were NOT successfully set into the variable named "' . $variableName . '".'
        );

    }

    /**
     * Add a file to a field by a given id on top of its existing list
     *
     * @param string $path                 File path
     * @param string $inputHelperElementId The id of the <input> helper for creating the File object
     * @param string $variableName         The name of the variable which holds an array of File objects
     */
    protected function loadFileToScriptVariable($path, $inputHelperElementId, $variableName)
    {
        $this->attachAFileToField($path, $inputHelperElementId);

        $mergeNewFileToFileListJavaScript = <<<JS
            var helperElement = document.getElementById('$inputHelperElementId');
            $variableName [$variableName.length] = helperElement.files[0];
JS;
        $this->getSession()->executeScript($mergeNewFileToFileListJavaScript);
    }

    /**
     * Collect the real path of a file, or all files in a directory and under
     *
     * @param string $path File or directory path
     *
     * @return array An array of files that is under the $path
     */
    protected function collectFileList($path)
    {
        $realPath = realpath($path);
        $filePathArray = array();

        switch (true) {
            case is_file($realPath) :
                $filePathArray[] = $realPath;

                continue;

            case is_dir($realPath) :
                $iterator = new \RecursiveIteratorIterator(
                    new \RecursiveDirectoryIterator($realPath),
                    \RecursiveIteratorIterator::CHILD_FIRST
                );

                foreach ($iterator as $item) {
                    if (substr_count($item->getPathname(), '/.') == 0 && ($item->isFile() || $item->isLink())) {
                        $filePathArray[] = $item->getPathname();
                    }
                }

                continue;

            default :
                $message = 'The provided path is neither a file nor a directory: ' . $realPath;
                throw new \Exception($message);
        }

        return $filePathArray;
    }

    /**
     * Trigger a "drop" Event by using the array variable which holds File objects
     *
     * @param string $variableName  The name of the variable which holds an array of File objects
     * @param string $elementFinder The JavaScript which is used for finding the target element
     */
    protected function triggerDropEvent($variableName, $elementFinder)
    {
        $triggerDropEventJavaScript = <<<JS
            var event = document.createEvent("HTMLEvents");
            event.initEvent("drop", true, true);

            event.dataTransfer = {};
            event.dataTransfer.files = $variableName;

            document.$elementFinder.dispatchEvent(event);
JS;
        $this->getSession()->executeScript($triggerDropEventJavaScript);
    }

    /**
     * Remove an element by its id
     *
     * @param string $elementId The id for the element to be removed
     */
    protected function removeElementById($elementId)
    {
        $removalJavaScript = <<<JS
            var targetElement = document.getElementById('$elementId');
            document.body.removeChild(targetElement);
JS;
        $this->getSession()->executeScript($removalJavaScript);

        $assertInputHelperNotExistJavaScript = <<<JS
            if (document.getElementById('$elementId')) {
                return false;
            }

            return true;
JS;
        $this->assertByJavaScript(
            $assertInputHelperNotExistJavaScript,
            'The target element with id="' . $elementId . '" was NOT successfully removed.'
        );
    }

    /**
     * Assert by running the JavaScript
     *
     * @param string $javaScript The JavaScript to assert
     * @param string $failReason The reason why JavaScript asserts false
     *
     * @throws \Exception
     */
    protected function assertByJavaScript($javaScript, $failReason)
    {
        if ( ! $this->getSession()->evaluateScript($javaScript)) {
            $message = 'A JavaScript assertion has yielded false: ' . $failReason;
            throw new \Exception($message);
        }
    }

    /**
     * Reveal an element
     *
     * @param string $elementId The id for the element to be revealed
     *
     * @Given /^(?:|I )reveal the "([^"]*)" element$/
     */
    public function revealElement($elementId)
    {
        $revealElementJavaScript = <<<JS
            var targetElement = document.getElementById('$elementId');
            targetElement.style.display    = 'block';
            targetElement.style.visibility = 'visible';
JS;
        $this->getSession()->executeScript($revealElementJavaScript);

        $assertElementRevealedJavaScript = <<<JS
            var targetElement = document.getElementById('$elementId');
            if (targetElement.style.display != 'block' || targetElement.style.visibility != 'visible') {
                return false;
            }

            return true;
JS;
        $this->assertByJavaScript(
            $assertElementRevealedJavaScript,
            'The target element with id="' . $elementId . '" was NOT successfully revealed.'
        );
    }

    /**
     * Conceal an element
     *
     * @param string $elementId The id for the element to be concealed
     *
     * @Given /^(?:|I )conceal the "([^"]*)" element$/
     */
    public function concealElement($elementId)
    {
        $concealElementJavaScript = <<<JS
            var targetElement = document.getElementById('$elementId');
            targetElement.style.display    = 'none';
            targetElement.style.visibility = 'hidden';
JS;
        $this->getSession()->executeScript($concealElementJavaScript);

        $assertElementConcealedJavaScript = <<<JS
            var targetElement = document.getElementById('$elementId');
            if (targetElement.style.display != 'none' || targetElement.style.visibility != 'hidden') {
                return false;
            }

            return true;
JS;
        $this->assertByJavaScript(
            $assertElementConcealedJavaScript,
            'The target element with id="' . $elementId . '" was NOT successfully concealed.'
        );
    }

    /**
     * Removes an attribute from an element.
     *
     * @param string $elementId            Element's id
     * @param string $elementAttributeName Element's attribute name
     *
     * @Given /^element "([^"]*)" attribute "([^"]*)" is removed$/
     */
    public function elementAttributeRemoved($elementId, $elementAttributeName)
    {
        $this->elementShouldExist($elementId);

        $removeElementAttributeJavaScript = <<<JS
            document.getElementById('$elementId').removeAttribute('$elementAttributeName');
JS;
        $this->getSession()->executeScript($removeElementAttributeJavaScript);

        $assertElementAttributeNotExistJavaScript = <<<JS
            var targetAttribute = document.getElementById('$elementId').getAttribute('$elementAttributeName');
            if (targetAttribute) {
                return false;
            }

            return true;
JS;
        $this->assertByJavaScript(
            $assertElementAttributeNotExistJavaScript,
            'The target element\'s attribute "' . $elementAttributeName . '" was not successfully removed.'
        );
    }

    /**
     * Checks whether a specified element exists.
     *
     * @param string $elementId Element's id
     */
    protected function elementShouldExist($elementId)
    {
        $assertElementExistsJavaScript = <<<JS
            var targetElement = document.getElementById('$elementId');
            if ( ! targetElement) {
                return false;
            }

            return true;
JS;
        $this->assertByJavaScript(
            $assertElementExistsJavaScript,
            'The target element with id="' . $elementId . '" does not exist.'
        );
    }

    /**
     * Get a piece of JavaScript code which retrieves an element by XPath
     *
     * @param string $xPath Element's XPath
     *
     * @return string
     */
    protected function getRetrieveElementByXPathJavaScript($xPath)
    {
        return 'document.evaluate("'. $xPath . '" ,document, null, XPathResult.FIRST_ORDERED_NODE_TYPE, null).singleNodeValue';
    }

    /**
     * Checks whether a specified element at the XPath exists.
     *
     * @param string $xPath Element's xPath
     *
     * @Then /^I should see an element at XPath "([^"]*)"$/
     */
    public function elementAtXPathShouldExist($xPath)
    {
        $retrieveElementJavaScript = $this->getRetrieveElementByXPathJavaScript($xPath);

        $assertElementAtXPathExistsJavaScript = <<<JS
            var targetElement = $retrieveElementJavaScript;
            if ( ! targetElement) {
                return false;
            }

            return true;
JS;
        $this->assertByJavaScript(
            $assertElementAtXPathExistsJavaScript,
            'The target element at XPath="' . $xPath . '" does not exist (which should).'
        );
    }

    /**
     * Checks whether a specified element at the XPath doesn't exist.
     *
     * @param string $xPath Element's xPath
     *
     * @Then /^I should not see an element at XPath "([^"]*)"$/
     */
    public function elementAtXPathShouldNotExist($xPath)
    {
        $retrieveElementJavaScript = $this->getRetrieveElementByXPathJavaScript($xPath);

        $assertElementAtXPathExistsJavaScript = <<<JS
            var targetElement = $retrieveElementJavaScript;
            if ( ! targetElement) {
                return true;
            }

            return false;
JS;
        $this->assertByJavaScript(
            $assertElementAtXPathExistsJavaScript,
            'The target element at XPath="' . $xPath . '" exists (which should not).'
        );
    }

    /**
     * Assert a specified attribute of a specified element exists.
     *
     * @param string $elementId            Element's id
     * @param string $elementAttributeName Element's attribute name
     *
     * @Then /^element "([^"]*)" should have an attribute "([^"]*)"$/
     */
    public function elementAttributeShouldExist($elementId, $elementAttributeName)
    {
        $this->elementShouldExist($elementId);

        $assertElementAttributeExistsJavaScript = <<<JS
            var targetAttribute = document.getElementById('$elementId').hasAttribute('$elementAttributeName');
            if ( ! targetAttribute) {
                return false;
            }

            return true;
JS;
        $this->assertByJavaScript(
            $assertElementAttributeExistsJavaScript,
            'The target element\'s attribute "' . $elementAttributeName . '" does not exist (which should).'
        );
    }

    /**
     * Assert a specified attribute of a specified element does not exist.
     *
     * @param string $elementId            Element's id
     * @param string $elementAttributeName Element's attribute name
     *
     * @Then /^element "([^"]*)" should not have an attribute "([^"]*)"$/
     */
    public function elementAttributeShouldNotExist($elementId, $elementAttributeName)
    {
        $this->elementShouldExist($elementId);

        $assertElementAttributeExistsJavaScript = <<<JS
            var targetAttribute = document.getElementById('$elementId').hasAttribute('$elementAttributeName');
            if (targetAttribute) {
                return false;
            }

            return true;
JS;
        $this->assertByJavaScript(
            $assertElementAttributeExistsJavaScript,
            'The target element\'s attribute "' . $elementAttributeName . '" exists (which should not).'
        );
    }

    /**
     * Assert a specified attribute of a specified element at XPath exists.
     *
     * @param string $xPath                Element's XPath
     * @param string $elementAttributeName Element's attribute name
     *
     * @Then /^element at XPath "([^"]*)" should have an attribute "([^"]*)"$/
     */
    public function elementAtXPathAttributeShouldExist($xPath, $elementAttributeName)
    {
        $this->elementAtXPathShouldExist($xPath);

        $retrieveElementJavaScript = $this->getRetrieveElementByXPathJavaScript($xPath);

        $assertElementAttributeExistsJavaScript = <<<JS
            var targetAttribute = $retrieveElementJavaScript.hasAttribute('$elementAttributeName');
            if ( ! targetAttribute) {
                return false;
            }

            return true;
JS;
        $this->assertByJavaScript(
            $assertElementAttributeExistsJavaScript,
            'The target element\'s attribute "' . $elementAttributeName . '" does not exist (which should).'
        );
    }

    /**
     * Assert a specified attribute of a specified element does not exist.
     *
     * @param string $xPath                Element's XPath
     * @param string $elementAttributeName Element's attribute name
     *
     * @Then /^element at XPath "([^"]*)" should not have an attribute "([^"]*)"$/
     */
    public function elementAtXPathAttributeShouldNotExist($xPath, $elementAttributeName)
    {
        $this->elementAtXPathShouldExist($xPath);

        $retrieveElementJavaScript = $this->getRetrieveElementByXPathJavaScript($xPath);

        $assertElementAttributeExistsJavaScript = <<<JS
            var targetAttribute = $retrieveElementJavaScript.hasAttribute('$elementAttributeName');
            if (targetAttribute) {
                return false;
            }

            return true;
JS;
        $this->assertByJavaScript(
            $assertElementAttributeExistsJavaScript,
            'The target element\'s attribute "' . $elementAttributeName . '" exists (which should not).'
        );
    }

    /**
     * Validate an attribute's value of a specified (by id) element.
     *
     * @param string $elementId                   Element's id
     * @param string $elementAttributeName        Element's attribute name
     * @param string $elementAttributeTargetValue Element's attribute value
     *
     * @Then /^element "([^"]*)" should have an attribute "([^"]*)" that is "([^"]*)"$/
     */
    public function elementHasAttributeOfValue($elementId, $elementAttributeName, $elementAttributeTargetValue)
    {
        $this->elementAttributeShouldExist($elementId, $elementAttributeName);

        $retrieveElementAttributeValueJavaScript = <<<JS
            return document.getElementById('$elementId').getAttribute('$elementAttributeName');
JS;

        $retrievedAttribute = $this->getSession()->evaluateScript($retrieveElementAttributeValueJavaScript);

        if ($retrievedAttribute != $elementAttributeTargetValue) {
            $message = 'The target element attribute "' . $elementAttributeTargetValue . '" does not match the element attribute\'s actual value "'. $retrievedAttribute . '"';
            throw new \Exception($message);
        }
    }

    /**
     * Validate an attribute's value of a specified (by XPath) element, as checking for exact match.
     *
     * @param string $xPath                       Element's XPath
     * @param string $elementAttributeName        Element's attribute name
     * @param string $elementAttributeTargetValue Element's attribute value
     *
     * @Then /^element at XPath "([^"]*)" should have an attribute "([^"]*)" that is "([^"]*)"$/
     */
    public function elementAtXPathHasAttributeOfValue($xPath, $elementAttributeName, $elementAttributeTargetValue)
    {
        $this->elementAtXPathAttributeShouldExist($xPath, $elementAttributeName);

        $retrieveElementJavaScript = $this->getRetrieveElementByXPathJavaScript($xPath);

        $retrieveElementAttributeValueJavaScript = <<<JS
            return $retrieveElementJavaScript.getAttribute('$elementAttributeName');
JS;

        $retrievedAttribute = $this->getSession()->evaluateScript($retrieveElementAttributeValueJavaScript);

        if ($retrievedAttribute != $elementAttributeTargetValue) {
            $message = 'The target element attribute "' . $elementAttributeTargetValue . '" does not match the element attribute\'s actual value "'. $retrievedAttribute . '"';
            throw new \Exception($message);
        }
    }

    /**
     * Validate an attribute's value of a specified (by XPath) element, as check if the value contains a specific string.
     *
     * @param string $xPath                           Element's XPath
     * @param string $elementAttributeName            Element's attribute name
     * @param string $elementAttributeTargetSubstring Element's attribute target substring
     *
     * @Then /^element at XPath "([^"]*)" should have an attribute "([^"]*)" that contains "([^"]*)"$/
     */
    public function elementAtXPathHasAttributeOfSubstring($xPath, $elementAttributeName, $elementAttributeTargetSubstring)
    {
        $this->elementAtXPathAttributeShouldExist($xPath, $elementAttributeName);

        $retrieveElementJavaScript = $this->getRetrieveElementByXPathJavaScript($xPath);

        $retrieveElementAttributeValueJavaScript = <<<JS
            return $retrieveElementJavaScript.getAttribute('$elementAttributeName');
JS;

        $retrievedAttribute = $this->getSession()->evaluateScript($retrieveElementAttributeValueJavaScript);

        if (false === stristr($retrievedAttribute, $elementAttributeTargetSubstring)) {
            $message = 'The target element attribute "' . $elementAttributeTargetSubstring . '" does not appear in the element attribute\'s actual value "'. $retrievedAttribute . '"';
            throw new \Exception($message);
        }
    }

    /**
     * Clicks a clickable element with specified XPath
     *
     * @param string $xPath XPath of the element to be clicked on
     *
     * @When /^(?:|I )click on the element at XPath "([^"]*)"$/
     */
    public function clickElementByXPath($xPath)
    {
        $element = $this->findElementByXpath($xPath);

        if ( ! $element) {
            $message = 'Could not find the element by the given XPath: ' . $xPath;
            throw new \Exception($message);
        }

        $element->click();
    }

    /**
     * Finds element with specified XPath.
     *
     * @param string $xPath XPath
     *
     * @return NodeElement|null
     */
    private function findElementByXpath($xPath)
    {
        return $this->getSession()->getPage()->find('xpath', $xPath);
    }

    /**
     * Wait for specified number of seconds
     *
     * @param string $delay Delay in seconds
     *
     * @When /^(?:|I )wait (\d+) seconds?$/
     */
    public function iWaitSecond($delay)
    {
        sleep($delay);
    }

    /**
     * Fills in form field with random text of required length
     *
     * Example:
     *   When I fill in "description" with 4096 random characters
     *
     * @param string  $field  Field id|name|label
     * @param integer $length Number of random characters
     *
     * @When /^(?:|I )fill in "(?P<field>(?:[^"]|\\")*)" with (?P<length>\d+) random characters?$/
     */
    public function fillFieldWithRandomText($field, $length)
    {
        $charset = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

        $value = '';

        for ($i = 0; $i < $length; $i++) {
            $value .= $charset[mt_rand(1, strlen($charset)) - 1];
        }

        $this->getMainContext()->fillField($field, $value);
    }

    /**
     * Adjust Jcrop selection box to certain coordinates
     *
     * @param string  $targetImageId Target Image Id
     * @param integer $positionX     Position X
     * @param integer $positionY     Position Y
     * @param integer $width         Width
     * @param integer $height        Height
     *
     * @Then /^(?:|I )adjust the selection box on image "([^"]*)" to X "(\d+)", Y "(\d+)", width "(\d+)" and height "(\d+)"$/
     */
    protected function adjustJcropSelectionBox($targetImageId, $positionX, $positionY, $width, $height)
    {
        $adjustJcropSelectionBoxJavaScript = <<<JS
            $('#$targetImageId').data('jcrop-api').animateTo([$positionX, $positionY, $positionX + $width, $positionY + $height]);
JS;
        $this->getSession()->executeScript($adjustJcropSelectionBoxJavaScript);

        $assertJcropSelectionBoxJavaScript = <<<JS
            selectedArea = $('#$targetImageId').data('jcrop-api').tellSelect();

            if (selectedArea.x  == $positionX &&
                selectedArea.y  == $positionY &&
                selectedArea.x2 == $positionX + $width &&
                selectedArea.y2 == $positionY + $height &&
                selectedArea.w  == $width &&
                selectedArea.h  == $height &&
               ) {
                return true;
            }

            return false;
JS;
        $this->assertByJavaScript(
            $assertJcropSelectionBoxJavaScript,
            'Could not adjust Jcrop selection box on the specified image with id="' . $targetImageId .
            ' and position X ' . $positionX .
            ', position Y ' . $positionY .
            ', width ' . $width .
            ' and height ' . $height .
            '.'
        );
    }
    
    /**
     * @Given /^I should see "([^"]*)" in the element at XPath "([^"]*)"$/
     */
    public function iShouldSeeInTheElementAtXpath($arg1, $xPath)
    {
        return $this->getSession()->getPage()->find('xpath', $xPath);
    }
}
