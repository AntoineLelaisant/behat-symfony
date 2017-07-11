Feature: List todos
  In order to know which todos left
  As an anonymous user
  I should be able to list all the remaining todos

    @domain-only
    Scenario: List all todos
        Given I am on homepage
        Then I should see a list of todos

    @javascript 
    Scenario: Search through todos
        Given I am on homepage
        When I search for "Todo 2"
        Then I should see one todo listed
        And I should see the todo "Todo 2"
