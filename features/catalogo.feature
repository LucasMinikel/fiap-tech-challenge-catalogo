Feature: Gerenciamento de Catálogo
  
  Scenario: Adicionar um novo item ao catálogo
    Given eu tenho um novo item "Hambúrguer" com preço 15.99
    When eu adiciono este item ao catálogo
    Then o item "Hambúrguer" deve estar no catálogo com preço 15.99