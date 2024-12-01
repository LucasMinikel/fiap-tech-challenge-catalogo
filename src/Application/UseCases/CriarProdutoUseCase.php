<?php

namespace App\Application\UseCases;

use App\Domain\Entities\Produto;
use App\Domain\Repositories\ProdutoRepositoryInterface;

class CriarProdutoUseCase
{
    private ProdutoRepositoryInterface $produtoRepository;

    public function __construct(ProdutoRepositoryInterface $produtoRepository)
    {
        $this->produtoRepository = $produtoRepository;
    }

    public function execute(array $data): Produto
    {
        $produto = new Produto(
            'PROD' . uniqid(),
            $data['nome'],
            $data['descricao'],
            $data['preco'],
            $data['image'],
            $data['categoria_id']
        );

        $this->produtoRepository->save($produto);

        return $produto;
    }
}
