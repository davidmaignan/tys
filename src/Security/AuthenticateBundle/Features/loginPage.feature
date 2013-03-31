# language: en
Feature: Login page

    @javascript
    Scenario: Check the login page functionality

        #Success
        Given   I am on "/app_dev.php/login/"
        Then    I fill in "user" for the element at XPath ".//*[@id='content']/div/div/div/div/form/div[1]/div/input"
        Then    I fill in "userpass" for the element at XPath ".//*[@id='content']/div/div/div/div/form/div[2]/div/input"
        And     I wait 1 seconds
        Then    I click on the element at XPath ".//*[@id='content']/div/div/div/div/form/div[3]/button"
        Then    I should see "Logged in as user"

        # Logout
        Then    I follow "Logout"
        Then    I am on "/app_dev.php/"
        And     I should see "Login"

        # Failure without username
        Given   I am on "/app_dev.php/login/"
        Then    I fill in "userpass" for the element at XPath ".//*[@id='content']/div/div/div/div/form/div[2]/div/input"
        And     I wait 1 seconds
        Then    I click on the element at XPath ".//*[@id='content']/div/div/div/div/form/div[3]/button"
        Then    I should see "Invalid username or password"

        # Failure without password
        Given   I am on "/app_dev.php/login/"
        Then    I fill in "user" for the element at XPath ".//*[@id='content']/div/div/div/div/form/div[1]/div/input"
        And     I wait 1 seconds
        Then    I click on the element at XPath ".//*[@id='content']/div/div/div/div/form/div[3]/button"
        Then    I should see "Invalid username or password"

      