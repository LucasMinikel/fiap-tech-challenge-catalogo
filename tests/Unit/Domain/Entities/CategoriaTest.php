<?php

namespace Tests\Unit\Domain\Entities;

use App\Domain\Entities\Categoria;
use PHPUnit\Framework\TestCase;

class CategoriaTest extends TestCase
{
    public function testCriacaoDeCategoria()
    {
        $categoria = new Categoria('CATE123', 'Nome da Categoria');

        $this->assertEquals('CATE123', $categoria->getId());
        $this->assertEquals('Nome da Categoria', $categoria->getNome());
    }

    public function testAtualizacaoDeCategoria()
    {
        $categoria = new Categoria('CATE123', 'Nome Original');
        $categoria->setNome('Nome Atualizado');

        $this->assertEquals('Nome Atualizado', $categoria->getNome());
    }
}
