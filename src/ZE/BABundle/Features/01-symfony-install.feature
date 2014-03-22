Feature: Login to the admin area
  As an administrator
  I want to be able to log into an admin area
  So I can administer app

  Scenario: Admin user logs into the admin area
    Given I am logged in as admin
    And I go to "/admin/dashboard"
    Then I should see ""
    Then the response status code should be 200

  Scenario: Bob user logs into the admin area
    Given I am logged in as Bob
    And I go to "/admin/dashboard"
    Then I should see "Access Denied"
    Then the response status code should be 403