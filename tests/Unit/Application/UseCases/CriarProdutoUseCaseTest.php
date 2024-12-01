<?php

namespace Tests\Unit\Application\UseCases;

use App\Application\UseCases\CriarProdutoUseCase;
use App\Domain\Entities\Produto;
use App\Domain\Repositories\ProdutoRepositoryInterface;
use PHPUnit\Framework\TestCase;

class CriarProdutoUseCaseTest extends TestCase
{
    public function testExecute()
    {
        $produtoRepositoryMock = $this->createMock(ProdutoRepositoryInterface::class);
        $produtoRepositoryMock->expects($this->once())
            ->method('save')
            ->with($this->isInstanceOf(Produto::class));

        $useCase = new CriarProdutoUseCase($produtoRepositoryMock);

        $data = [
            'nome' => 'Produto Teste',
            'descricao' => 'Descrição do Produto Teste',
            'preco' => 10.99,
            'image' => 'imagem.jpg',
            'categoria_id' => 'CATE456'
        ];

        $produto = $useCase->execute($data);

        $this->assertInstanceOf(Produto::class, $produto);
        $this->assertEquals('Produto Teste', $produto->getNome());
        $this->assertEquals('Descrição do Produto Teste', $produto->getDescricao());
        $this->assertEquals(10.99, $produto->getPreco());
        $this->assertEquals('imagem.jpg', $produto->getImage());
        $this->assertEquals('CATE456', $produto->getCategoriaId());
    }
}
