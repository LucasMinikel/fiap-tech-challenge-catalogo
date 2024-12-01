<?php

namespace Tests\Unit\Application\UseCases;

use App\Application\DTOs\ProdutoDTO;
use App\Application\UseCases\AtualizarProdutoUseCase;
use App\Domain\Entities\Produto;
use App\Domain\Repositories\ProdutoRepositoryInterface;
use App\Domain\Exceptions\ProdutoNotFoundException;
use PHPUnit\Framework\TestCase;

class AtualizarProdutoUseCaseTest extends TestCase
{
    public function testExecuteComSucesso()
    {
        $produtoExistente = new Produto('PROD123', 'Nome Antigo', 'Descrição Antiga', 9.99, 'imagem_antiga.jpg', 'CATE456');

        $produtoRepositoryMock = $this->createMock(ProdutoRepositoryInterface::class);
        $produtoRepositoryMock->expects($this->once())
            ->method('findById')
            ->with('PROD123')
            ->willReturn($produtoExistente);
        $produtoRepositoryMock->expects($this->once())
            ->method('update')
            ->with($this->isInstanceOf(Produto::class));

        $useCase = new AtualizarProdutoUseCase($produtoRepositoryMock);

        $dto = new ProdutoDTO('PROD123', 'Nome Novo', 'Descrição Nova', 10.99, 'imagem_nova.jpg', 'CATE789');

        $result = $useCase->execute('PROD123', $dto);

        $this->assertInstanceOf(ProdutoDTO::class, $result);
        $this->assertEquals('PROD123', $result->id);
        $this->assertEquals('Nome Novo', $result->nome);
        $this->assertEquals('Descrição Nova', $result->descricao);
        $this->assertEquals(10.99, $result->preco);
        $this->assertEquals('imagem_nova.jpg', $result->image);
        $this->assertEquals('CATE789', $result->categoriaId);
    }

    public function testExecuteComProdutoNaoEncontrado()
    {
        $produtoRepositoryMock = $this->createMock(ProdutoRepositoryInterface::class);
        $produtoRepositoryMock->expects($this->once())
            ->method('findById')
            ->with('PROD123')
            ->willReturn(null);

        $useCase = new AtualizarProdutoUseCase($produtoRepositoryMock);

        $dto = new ProdutoDTO('PROD123', 'Nome Novo', 'Descrição Nova', 10.99, 'imagem_nova.jpg', 'CATE789');

        $this->expectException(ProdutoNotFoundException::class);
        $useCase->execute('PROD123', $dto);
    }
}
