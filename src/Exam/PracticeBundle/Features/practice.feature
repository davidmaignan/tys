# @author David Maignan <davidmaignan@gmail.com>

@javascript
Feature: Practice an exam

    Background:
        Given the following activated user exists:
            | login                          | password  | screenName          | role                |
            | testexamowner1@testmail.com    | qwe123    | testexamowner1      | ROLE_EXAM_OWNER     |
            | testexampractice1@testmail.com | qwe123    | testexampractice1   | ROLE_EXAM_CANDIDATE |
    
        Given the following exam exists:
            | language  | number_candidates | level         | number_questions   | type          | tags                                                    | owner          | candidate         |
            | PHP       | 1                 | intermediate  | 20                 |multi-choice   | core, strings, array, namespace, PDO, cookie, functions | testexamowner1 | testexampractice1 |

    Scenario: Assert a user's presence is displayed correctly on the page

        #When I am logged in as "testexampractice1@testmail.com" with "qwe123"
        #And I wait 2 seconds
        #Then I should be on "/home"

        #Success
        Given   I am on "/app_test.php"
        Then    I follow "Login"
        Then    I wait 1 second
        Then    I fill in "testexampractice1" for "username"
        And     I fill in "qwe123" for "password"
        Then    I press "loginBtn"
        Then    I should see "Logged in as testexampractice1"

        Given   I am on "app_test.php/test/list"
        Then    I should see "Review"
        And     I follow on the element at XPath ".//body/div[4]/div/div/table/tbody/tr[1]/td[9]/a"