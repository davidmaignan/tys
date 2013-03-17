# language: en
Feature: Exam List

    @javascript
    Scenario: Check the exam list functionality

        #Success
        Given   I am on "/app_dev.php/"
        Then    I follow "Login"
        Then    I wait 1 second
        Then    I fill in "user" for "username"
        And     I fill in "userpass" for "password"
        Then    I press "loginBtn"
        Then    I should see "Logged in as user"
        Then    I am on "/app_dev.php/exam/list"
        Then    I should see "Your exams"



        
