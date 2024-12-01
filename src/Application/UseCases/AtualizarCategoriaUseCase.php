<?php

namespace App\Application\UseCases;

use App\Domain\Entities\Categoria;
use App\Domain\Repositories\CategoriaRepositoryInterface;
use App\Domain\Exceptions\CategoriaNotFoundException;

class AtualizarCategoriaUseCase
{
    private CategoriaRepositoryInterface $categoriaRepository;

    public function __construct(CategoriaRepositoryInterface $categoriaRepository)
    {
        $this->categoriaRepository = $categoriaRepository;
    }

    public function execute(string $id, array $data): Categoria
    {
        $categoria = $this->categoriaRepository->findById($id);

        if (!$categoria) {
            throw new CategoriaNotFoundException("Categoria com ID $id não encontrada.");
        }

        $categoria->setNome($data['nome'] ?? $categoria->getNome());

        $this->categoriaRepository->update($categoria);

        return $categoria;
    }
}
