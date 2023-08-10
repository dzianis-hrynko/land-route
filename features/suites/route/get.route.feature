Feature: Testing the /routing/{origin}/{destination} endpoint

  Scenario: Get routing information about borders between Czech Republic and Italy
    When I send request "routing/CZE/ITA" using HTTP GET
    Then the response code is 200
    And the response body contains JSON:
    """"
      {"route":["CZE","AUT","ITA"]}
    """

  Scenario: Get routing information about borders between Belarus and Portugal
    When I send request "routing/blr/PRT" using HTTP GET
    Then the response code is 200
    And the response body contains JSON:
    """"
      {"route":["BLR","POL","DEU","FRA","ESP","PRT"]}
    """
  Scenario: Get routing information for one country
    When I send request "routing/CZE/CZE" using HTTP GET
    Then the response code is 400
    And the response body contains JSON:
    """"
      {"message":"Origin and destination countries are the same."}
    """

  Scenario: Get routing information for with bad request data
    When I send request "routing/CZE/rt" using HTTP GET
    Then the response code is 400
    And the response body contains JSON:
    """"
      {"message":"Invalid route request value"}
    """

  Scenario: Get routing information for with bad request data
    When I send request "routing/CZE/" using HTTP GET
    Then the response code is 404
