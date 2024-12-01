<?php

namespace Tests\Unit\Application\UseCases;

use App\Application\UseCases\CriarCategoriaUseCase;
use App\Domain\Entities\Categoria;
use App\Domain\Repositories\CategoriaRepositoryInterface;
use PHPUnit\Framework\TestCase;

class CriarCategoriaUseCaseTest extends TestCase
{
    public function testExecute()
    {
        $categoriaRepositoryMock = $this->createMock(CategoriaRepositoryInterface::class);
        $categoriaRepositoryMock->expects($this->once())
            ->method('save')
            ->with($this->isInstanceOf(Categoria::class));

        $useCase = new CriarCategoriaUseCase($categoriaRepositoryMock);

        $data = [
            'nome' => 'Categoria Teste'
        ];

        $categoria = $useCase->execute($data);

        $this->assertInstanceOf(Categoria::class, $categoria);
        $this->assertEquals('Categoria Teste', $categoria->getNome());
    }
}
