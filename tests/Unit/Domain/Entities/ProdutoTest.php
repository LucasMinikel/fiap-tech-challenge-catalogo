<?php

namespace Tests\Unit\Domain\Entities;

use App\Domain\Entities\Produto;
use PHPUnit\Framework\TestCase;

class ProdutoTest extends TestCase
{
    public function testCriacaoDeProduto()
    {
        $produto = new Produto(
            'PROD123',
            'Produto Teste',
            'Descrição do Produto Teste',
            10.99,
            'imagem.jpg',
            'CATE456'
        );

        $this->assertEquals('PROD123', $produto->getId());
        $this->assertEquals('Produto Teste', $produto->getNome());
        $this->assertEquals('Descrição do Produto Teste', $produto->getDescricao());
        $this->assertEquals(10.99, $produto->getPreco());
        $this->assertEquals('imagem.jpg', $produto->getImage());
        $this->assertEquals('CATE456', $produto->getCategoriaId());
    }

    public function testAtualizacaoDeProduto()
    {
        $produto = new Produto(
            'PROD123',
            'Produto Teste',
            'Descrição do Produto Teste',
            10.99,
            'imagem.jpg',
            'CATE456'
        );

        $produto->setNome('Novo Nome');
        $produto->setDescricao('Nova Descrição');
        $produto->setPreco(15.99);
        $produto->setImage('nova_imagem.jpg');
        $produto->setCategoriaId('CATE789');

        $this->assertEquals('Novo Nome', $produto->getNome());
        $this->assertEquals('Nova Descrição', $produto->getDescricao());
        $this->assertEquals(15.99, $produto->getPreco());
        $this->assertEquals('nova_imagem.jpg', $produto->getImage());
        $this->assertEquals('CATE789', $produto->getCategoriaId());
    }
}
