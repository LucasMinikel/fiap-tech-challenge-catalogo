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
    private CategoriaRepositoryInterface $categoriaRepository;
    private AtualizarCategoriaUseCase $useCase;
    private Categoria $categoriaExistente;

    protected function setUp(): void
    {
        $this->categoriaExistente = new Categoria('CATE123', 'Nome Antigo');
        $this->categoriaRepository = $this->createMock(CategoriaRepositoryInterface::class);
        $this->useCase = new AtualizarCategoriaUseCase($this->categoriaRepository);
    }

    public function testExecuteComSucesso()
    {
        $this->categoriaRepository->expects($this->once())
            ->method('findById')
            ->with('CATE123')
            ->willReturn($this->categoriaExistente);

        $this->categoriaRepository->expects($this->once())
            ->method('update')
            ->with($this->isInstanceOf(Categoria::class));

        $dto = new CategoriaDTO('CATE123', 'Nome Novo');

        $result = $this->useCase->execute('CATE123', $dto);

        $this->assertInstanceOf(CategoriaDTO::class, $result);
        $this->assertEquals('CATE123', $result->id);
        $this->assertEquals('Nome Novo', $result->nome);
    }

    public function testExecuteComCategoriaNaoEncontrada()
    {
        $this->categoriaRepository->expects($this->once())
            ->method('findById')
            ->with('CATE123')
            ->willReturn(null);

        $dto = new CategoriaDTO('CATE123', 'Nome Novo');

        $this->expectException(CategoriaNotFoundException::class);
        $this->useCase->execute('CATE123', $dto);
    }

    public function testExecuteComIdsDiferentes()
    {
        $this->categoriaRepository->expects($this->once())
            ->method('findById')
            ->with('CATE123')
            ->willReturn($this->categoriaExistente);

        $this->categoriaRepository->expects($this->once())
            ->method('update')
            ->with($this->callback(function ($categoria) {
                return $categoria->getId() === 'CATE123' &&
                    $categoria->getNome() === 'Nome Novo';
            }));

        $dto = new CategoriaDTO('CATE456', 'Nome Novo');

        $result = $this->useCase->execute('CATE123', $dto);

        $this->assertEquals('CATE123', $result->id);
        $this->assertEquals('Nome Novo', $result->nome);
    }

    public function testExecuteComMesmoNome()
    {
        $this->categoriaRepository->expects($this->once())
            ->method('findById')
            ->with('CATE123')
            ->willReturn($this->categoriaExistente);

        $this->categoriaRepository->expects($this->once())
            ->method('update')
            ->with($this->callback(function ($categoria) {
                return $categoria->getId() === 'CATE123' &&
                    $categoria->getNome() === 'Nome Antigo';
            }));

        $dto = new CategoriaDTO('CATE123', 'Nome Antigo');

        $result = $this->useCase->execute('CATE123', $dto);

        $this->assertEquals('CATE123', $result->id);
        $this->assertEquals('Nome Antigo', $result->nome);
    }

    public function testExecuteComNomeVazio()
    {
        $this->categoriaRepository->expects($this->once())
            ->method('findById')
            ->with('CATE123')
            ->willReturn($this->categoriaExistente);

        $this->categoriaRepository->expects($this->once())
            ->method('update')
            ->with($this->callback(function ($categoria) {
                return $categoria->getId() === 'CATE123' &&
                    $categoria->getNome() === '';
            }));

        $dto = new CategoriaDTO('CATE123', '');

        $result = $this->useCase->execute('CATE123', $dto);

        $this->assertEquals('CATE123', $result->id);
        $this->assertEquals('', $result->nome);
    }
}
