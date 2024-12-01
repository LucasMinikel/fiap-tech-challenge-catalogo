<?php

namespace Tests\Unit\Application\UseCases;

use App\Application\DTOs\CategoriaDTO;
use App\Application\UseCases\AtualizarCategoriaUseCase;
use App\Domain\Entities\Categoria;
use App\Domain\Repositories\CategoriaRepositoryInterface;
use App\Domain\Exceptions\CategoriaNotFoundException;
use PHPUnit\Framework\TestCase;

class AtualizarCategoriaUseCaseTest extends TestCase
{
    public function testExecuteComSucesso()
    {
        $categoriaExistente = new Categoria('CATE123', 'Nome Antigo');

        $categoriaRepositoryMock = $this->createMock(CategoriaRepositoryInterface::class);
        $categoriaRepositoryMock->expects($this->once())
            ->method('findById')
            ->with('CATE123')
            ->willReturn($categoriaExistente);
        $categoriaRepositoryMock->expects($this->once())
            ->method('update')
            ->with($this->isInstanceOf(Categoria::class));

        $useCase = new AtualizarCategoriaUseCase($categoriaRepositoryMock);

        $dto = new CategoriaDTO('CATE123', 'Nome Novo');

        $result = $useCase->execute('CATE123', $dto);

        $this->assertInstanceOf(CategoriaDTO::class, $result);
        $this->assertEquals('CATE123', $result->id);
        $this->assertEquals('Nome Novo', $result->nome);
    }

    public function testExecuteComCategoriaNaoEncontrada()
    {
        $categoriaRepositoryMock = $this->createMock(CategoriaRepositoryInterface::class);
        $categoriaRepositoryMock->expects($this->once())
            ->method('findById')
            ->with('CATE123')
            ->willReturn(null);

        $useCase = new AtualizarCategoriaUseCase($categoriaRepositoryMock);

        $dto = new CategoriaDTO('CATE123', 'Nome Novo');

        $this->expectException(CategoriaNotFoundException::class);
        $useCase->execute('CATE123', $dto);
    }
}
