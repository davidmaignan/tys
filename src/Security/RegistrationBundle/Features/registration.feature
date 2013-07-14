# language: en
Feature: Registration

    @javascript
    Scenario: Check the registration functionality

        # Failing
        Given   I am on "/app_test.php/"
        Then    I follow "Register"
        Then 	I should be on "/app_test.php/register/"
        And     I should see "Sign Up"
        And		I press "_register"
        Then 	I should be on "/app_dev.php/register/"
        And		I should see "Please enter an email"
        And     I should see "Please enter a password"

        # Success
        Then    I fill in "john" for "Username"
        And	    I fill in "tomi.klemm@gmail.com" for "Email"
        And		I fill in "password1" for "Password"
        And     I fill in "password1" for "Verification"
        And     I wait 2 seconds
        Then	I press "_register"
        Then	I should see "Congrats john, your account is now activated"
        Then    I wait 2 seconds

        # Logout
        Then	I follow "Logout"
        Then 	I am on "/app_test.php/"

     