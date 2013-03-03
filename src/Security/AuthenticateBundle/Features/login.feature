# language: en
Feature: Login

    @javascript
    Scenario: Check the login functionality

        # Failing
        Given   I am on "/app_dev.php/login/"
        Then 	I should see "Remember me"
        And		I press "_submit"
        Then 	I should be on "/app_dev.php/login/"
        And		I should see "Invalid username or password"

        # Success
        Then	I fill in "user" for "username"
        And		I fill in "userpass" for "password"
        Then	I press "_submit"
        Then	I should see "Logged in as user"

        # Logout
        Then	I press "Logout"
        Then 	I am on "/app_dev.php/"

        