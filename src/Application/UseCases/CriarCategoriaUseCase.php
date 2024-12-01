<?php

namespace App\Application\UseCases;

use App\Domain\Entities\Categoria;
use App\Domain\Repositories\CategoriaRepositoryInterface;

class CriarCategoriaUseCase
{
    private CategoriaRepositoryInterface $categoriaRepository;

    public function __construct(CategoriaRepositoryInterface $categoriaRepository)
    {
        $this->categoriaRepository = $categoriaRepository;
    }

    public function execute(array $data): Categoria
    {
        $categoria = new Categoria(
            'CATE' . uniqid(),
            $data['nome']
        );

        $this->categoriaRepository->save($categoria);

        return $categoria;
    }
}
