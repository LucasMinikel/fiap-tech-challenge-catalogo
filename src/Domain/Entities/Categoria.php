<?php

namespace App\Domain\Entities;

class Categoria
{
    private string $id;
    private string $nome;

    public function __construct(string $id, string $nome)
    {
        $this->id = $id;
        $this->nome = $nome;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function setNome(string $nome): void
    {
        $this->nome = $nome;
    }
}
