Feature: List todos
  In order to know which todos left
  As an anonymous user
  I should be able to list all the remaining todos

    Scenario: List all todos
        Given I am on homepage
        Then I should see a list of todos
