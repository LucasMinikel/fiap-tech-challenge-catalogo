<?php

use Behat\Behat\Context\Context;
use App\Domain\Entities\Item;
use App\Infrastructure\Persistence\MockItemRepository;

class FeatureContext implements Context
{
    private $item;
    private $repository;

    public function __construct()
    {
        $this->repository = new MockItemRepository();
    }

    /**
     * @Given eu tenho um novo item :nome com preço :preco
     */
    public function euTenhoUmNovoItemComPreco($nome, $preco)
    {
        $this->item = new Item(null, $nome, (float)$preco);
    }

    /**
     * @When eu adiciono este item ao catálogo
     */
    public function euAdicionoEsteItemAoCatalogo()
    {
        $this->repository->save($this->item);
    }

    /**
     * @Then o item :nome deve estar no catálogo com preço :preco
     */
    public function oItemDeveEstarNoCatalogoComPreco($nome, $preco)
    {
        $item = $this->repository->findByNome($nome);
        if (!$item || $item->getPreco() != (float)$preco) {
            throw new Exception("Item não encontrado ou preço incorreto");
        }
    }
}
