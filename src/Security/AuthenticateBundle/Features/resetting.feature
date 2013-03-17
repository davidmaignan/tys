# language: en
Feature: Reset Password

    @javascript
    Scenario: Check the reset password functionality

        #Success
        Given   I am on "/app_dev.php/"
        Then    I follow "Login"
        Then    I wait 1 second
        Then    I follow "Forgot Password?"
        Then    I am on "/app_dev.php/resetting/request/"
        And     I fill in "user" for "username"
        Then    I press "_submit_resetting"
        Then    I should see "An email has been sent to"

        # Failing
        Given   I am on "/app_dev.php/"
        Then    I follow "Login"
        Then    I wait 1 second
        Then    I press "Forgot Password?"
        Then    I am on "/app_dev.php/resetting/request/"
        Then    I press "_submit_resetting"
        Then    I should see "Please fill out this field"

        
