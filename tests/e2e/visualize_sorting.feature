Feature: Sorting visualize

  Scenario Outline: Visit sorting page with ID
    Given a sorting exists in the database with <data> and <dataHashed>
    Examples:
      | data   | dataHashed                       |
      | [test] | b8450fa94958d7728a7612b38dcb4d41 |
    Given I am on the sorting page
    When I visit the sorting page with ID
    Then the response should contain the sorting result [test]

  Scenario: Visit sorting page without ID
    Given I visit the sorting page without ID
    Then the response should contain the sorting result []

  Scenario: Visit sorting page with ID but not exists
    Given I visit the sorting page with ID
    Then the response should contain the sorting result []