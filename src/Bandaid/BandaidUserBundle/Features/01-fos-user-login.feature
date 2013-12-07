#/sf_bandaid/features/01-fos-user-login.feature
Feature: Login as admin user
  In order to create a user-based application
  As a developer
  I need to be able to login with admin user
  Scenario: Login as admin user
    Given I am on the login page
    When I login with username admin and password admin
    Then I should be logged in successfully
