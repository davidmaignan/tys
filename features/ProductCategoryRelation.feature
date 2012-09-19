Feature: Product Category Relationship
  In order to setup a valid catalog
  As a developer
  I need a working relationship

Scenario: A category contains a product
  Given I have a category "Underwear"
    And I have a product "Calvin Klein Black, 5"
   When I add product "Calvin Klein Black, 5" to category "Underwear"
   Then I should find product "Calvin Klein Black, 5" in category "Underwear"