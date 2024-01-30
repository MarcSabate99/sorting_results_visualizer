Feature: Sorting generation

  Scenario: Generate visualizer with valid data
    Given I send a POST request to "/generate/visualizer" with:
      """
      {
         "elements":[
            {
               "title":"TOC Hostel and Suites Madrid",
               "imageUrl":"https://hotelmedia.stayforlong.com/medium/2141/2141079cfcf9f9fd-3938.jpg",
               "others":{
                  "price":"981 $",
                  "stars":"9.6",
                  "highlighted":"1"
               }
            }
         ]
      }
      """
    Then the response code should be 200
    And the response should contain a "sortingShareUrl" key

  Scenario: Generate visualizer with invalid data
    Given I send a POST request to "/generate/visualizer" with:
      """
      {}
      """
    Then the response code should be 500
    And the response should contain a "message" key