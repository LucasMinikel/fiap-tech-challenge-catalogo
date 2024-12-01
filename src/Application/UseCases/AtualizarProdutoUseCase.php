<?php

namespace App\Application\UseCases;

use App\Domain\Entities\Produto;
use App\Domain\Repositories\ProdutoRepositoryInterface;
use App\Domain\Exceptions\ProdutoNotFoundException;

class AtualizarProdutoUseCase
{
    private ProdutoRepositoryInterface $produtoRepository;

    public function __construct(ProdutoRepositoryInterface $produtoRepository)
    {
        $this->produtoRepository = $produtoRepository;
    }

    public function execute(string $id, array $data): Produto
    {
        $produto = $this->produtoRepository->findById($id);

        if (!$produto) {
            throw new ProdutoNotFoundException("Produto com ID $id não encontrado.");
        }

        $produto->setNome($data['nome'] ?? $produto->getNome());
        $produto->setDescricao($data['descricao'] ?? $produto->getDescricao());
        $produto->setPreco($data['preco'] ?? $produto->getPreco());
        $produto->setImage($data['image'] ?? $produto->getImage());
        $produto->setCategoriaId($data['categoria_id'] ?? $produto->getCategoriaId());

        $this->produtoRepository->update($produto);

        return $produto;
    }
}
