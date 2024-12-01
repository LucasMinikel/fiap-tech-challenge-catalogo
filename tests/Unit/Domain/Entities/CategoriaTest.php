<?php

namespace Tests\Unit\Domain\Entities;

use App\Domain\Entities\Categoria;
use PHPUnit\Framework\TestCase;

class CategoriaTest extends TestCase
{
    public function testCriacaoDeCategoria()
    {
        $categoria = new Categoria('CATE123', 'Categoria Teste');

        $this->assertEquals('CATE123', $categoria->getId());
        $this->assertEquals('Categoria Teste', $categoria->getNome());
    }

    public function testAtualizacaoDeCategoria()
    {
        $categoria = new Categoria('CATE123', 'Categoria Teste');

        $categoria->setNome('Nova Categoria');

        $this->assertEquals('Nova Categoria', $categoria->getNome());
    }
}
