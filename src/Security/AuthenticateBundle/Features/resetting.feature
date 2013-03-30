# language: en
Feature: Reset Password

    @javascript
    Scenario: Check the reset password functionality

        #Success
        Given   I am on "/app_dev.php/"
        Then    I follow "Login"
        Then    I wait 1 second
        Then    I follow "Forgot Password?"
        Then    I should be on "/app_dev.php/resetting/request"
        And     I fill in "user" for the element at XPath ".//body/div[3]/div/div/div/div/form/div[1]/input"
        Then    I press "_submit_resetting"
        Then    I should see "An email has been sent to"

        # Failing
        Given   I am on "/app_dev.php/"
        Then    I follow "Login"
        Then    I wait 1 second
        Then    I follow "Forgot Password?"
        Then    I should be on "/app_dev.php/resetting/request"
        Then    I press "_submit_resetting"
        Then    I should see "Please fill out this field"

        
