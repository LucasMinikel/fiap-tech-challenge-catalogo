<?php

namespace App\Domain\Entities;

class Produto
{
    private string $id;
    private string $nome;
    private string $descricao;
    private float $preco;
    private string $image;
    private string $categoriaId;

    public function __construct(
        string $id,
        string $nome,
        string $descricao,
        float $preco,
        string $image,
        string $categoriaId
    ) {
        $this->id = $id;
        $this->nome = $nome;
        $this->descricao = $descricao;
        $this->preco = $preco;
        $this->image = $image;
        $this->categoriaId = $categoriaId;
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

    public function getDescricao(): string
    {
        return $this->descricao;
    }

    public function setDescricao(string $descricao): void
    {
        $this->descricao = $descricao;
    }

    public function getPreco(): float
    {
        return $this->preco;
    }

    public function setPreco(float $preco): void
    {
        $this->preco = $preco;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    public function getCategoriaId(): string
    {
        return $this->categoriaId;
    }

    public function setCategoriaId(string $categoriaId): void
    {
        $this->categoriaId = $categoriaId;
    }
}
