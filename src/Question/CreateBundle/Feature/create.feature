# language: en
Feature: Create Question

    @javascript
    Scenario: Check the create question functionality

        # Not logged in 
        Given   I am on "/app_dev.php"
        Then    I follow "Question"
        Then    I wait 1 seconds
        Then    I should see "Create"
        And     I should see "Review"
        Then    I follow "Create"
        And     I wait 2 seconds 

        # Login
        Then    I fill in "user" for "username"
        And     I fill in "userpass" for "password"
        Then    I press "_submit"
        Then    I am on "/app_dev.php/question/create"
        And     I should see "Create a Question"

        # Failing
        And		I press "_submit_question"
        Then 	I should be on "/app_dev.php/question/create"
        And		I should see "This value should not be blank"

        # Filling 
        Then    I fill in "What is the latest PHP version available?" for "question_create_contributor_form_title"
        And     I fill in "5.4.12" for "question_create_contributor_form_answers_0_title"
        And     I wait 2 seconds

        # Add a second answer
        # And     I press "Add another answer"
        # Then    I wait 2 seconds
        # And     I should see "Title" in the element at XPath "//*[@id='question_create_contributor_form_answers_1']/div/label"
        # Then    I press "_submit_question"
        # Then    I should see "This value should not be blank"
        # Then    I wait 1 second

        # Fill in second answer
        #And     I fill in "5.4.10" for "question_create_contributor_form_answers_1_title"
        #Then    I should see "What is the latest PHP version available?"
        #And     I wait 1 second
        Then	I press "_submit_question"
        Then	I should see "Question Submitted"
        Then    I wait 1 second

        # Logout
        # Then	I follow "Logout"
        # Then 	I am on "/app_dev.php/"