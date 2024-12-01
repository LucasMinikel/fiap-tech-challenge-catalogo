<?php

namespace App\Application\UseCases;

use App\Domain\Repositories\ProdutoRepositoryInterface;
use App\Domain\Exceptions\ProdutoNotFoundException;

class DeletarProdutoUseCase
{
    private ProdutoRepositoryInterface $produtoRepository;

    public function __construct(ProdutoRepositoryInterface $produtoRepository)
    {
        $this->produtoRepository = $produtoRepository;
    }

    public function execute(string $id): void
    {
        $produto = $this->produtoRepository->findById($id);

        if (!$produto) {
            throw new ProdutoNotFoundException("Produto com ID $id não encontrado.");
        }

        $this->produtoRepository->delete($id);
    }
}
