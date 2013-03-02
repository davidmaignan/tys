# language: en
# Source: http://github.com/aslakhellesoy/cucumber/blob/master/examples/i18n/en/features/addition.feature
# Updated: Tue May 25 15:51:43 +0200 2010
Feature: Homepage

    @javascript
    Scenario: Check the homepage

        Given   I am on "/"
        Then    I should see "Welcome"