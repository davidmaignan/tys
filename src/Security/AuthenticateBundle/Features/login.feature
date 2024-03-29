# language: en
Feature: Login

    @javascript
    Scenario: Check the login functionality

        #Success
        Given   I am on "/app_dev.php"
        Then    I follow "Login"
        Then    I wait 1 second
        Then    I fill in "user" for "username"
        And     I fill in "userpass" for "password"
        Then    I press "loginBtn"
        Then    I should see "Logged in as user"

        # Logout
        Then    I follow "Logout"
        Then    I am on "/app_dev.php/"
        And     I should see "Login"

        # Failing with no input
        Given   I am on "/app_dev.php/"
        Then    I follow "Login"
        Then    I wait 2 seconds
        Then 	I should see "Remember me"
        And     I press "loginBtn"
        Then 	I should be on "/app_dev.php/login/"
        And	I should see "Invalid username or password"

        # Failing without username
        Given   I am on "/app_dev.php"
        Then    I follow "Login"
        Then    I wait 1 second
        Then    I fill in "userpass" for "password"
        Then    I press "loginBtn"
        Then    I should see "Invalid username or password"

        # Failing without password
        Given   I am on "/app_dev.php"
        Then    I follow "Login"
        Then    I wait 1 second
        Then    I fill in "user" for "username"
        Then    I press "loginBtn"
        Then    I should see "Invalid username or password"

        

        