<?php

namespace App\Infrastructure\API\Controllers;

use App\Application\UseCases\CriarProdutoUseCase;
use App\Application\UseCases\AtualizarProdutoUseCase;
use App\Application\UseCases\DeletarProdutoUseCase;
use App\Domain\Repositories\ProdutoRepositoryInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ProdutoController
{
    private CriarProdutoUseCase $criarProdutoUseCase;
    private AtualizarProdutoUseCase $atualizarProdutoUseCase;
    private DeletarProdutoUseCase $deletarProdutoUseCase;
    private ProdutoRepositoryInterface $produtoRepository;

    public function __construct(
        CriarProdutoUseCase $criarProdutoUseCase,
        AtualizarProdutoUseCase $atualizarProdutoUseCase,
        DeletarProdutoUseCase $deletarProdutoUseCase,
        ProdutoRepositoryInterface $produtoRepository
    ) {
        $this->criarProdutoUseCase = $criarProdutoUseCase;
        $this->atualizarProdutoUseCase = $atualizarProdutoUseCase;
        $this->deletarProdutoUseCase = $deletarProdutoUseCase;
        $this->produtoRepository = $produtoRepository;
    }

    public function criar(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();

        $produto = $this->criarProdutoUseCase->execute($data);

        $response->getBody()->write(json_encode([
            'id' => $produto->getId(),
            'nome' => $produto->getNome(),
            'descricao' => $produto->getDescricao(),
            'preco' => $produto->getPreco(),
            'image' => $produto->getImage(),
            'categoria_id' => $produto->getCategoriaId()
        ]));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }

    public function atualizar(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'];
        $data = $request->getParsedBody();

        try {
            $produto = $this->atualizarProdutoUseCase->execute($id, $data);

            $response->getBody()->write(json_encode([
                'id' => $produto->getId(),
                'nome' => $produto->getNome(),
                'descricao' => $produto->getDescricao(),
                'preco' => $produto->getPreco(),
                'image' => $produto->getImage(),
                'categoria_id' => $produto->getCategoriaId()
            ]));

            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(404);
        }
    }

    public function deletar(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'];

        try {
            $this->deletarProdutoUseCase->execute($id);

            return $response->withStatus(204);
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(404);
        }
    }

    public function listar(Request $request, Response $response): Response
    {
        $produtos = $this->produtoRepository->findAll();

        $data = array_map(function ($produto) {
            return [
                'id' => $produto->getId(),
                'nome' => $produto->getNome(),
                'descricao' => $produto->getDescricao(),
                'preco' => $produto->getPreco(),
                'image' => $produto->getImage(),
                'categoria_id' => $produto->getCategoriaId()
            ];
        }, $produtos);

        $response->getBody()->write(json_encode($data));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }

    public function obter(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'];
        $produto = $this->produtoRepository->findById($id);

        if (!$produto) {
            $response->getBody()->write(json_encode(['error' => 'Produto não encontrado']));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(404);
        }

        $response->getBody()->write(json_encode([
            'id' => $produto->getId(),
            'nome' => $produto->getNome(),
            'descricao' => $produto->getDescricao(),
            'preco' => $produto->getPreco(),
            'image' => $produto->getImage(),
            'categoria_id' => $produto->getCategoriaId()
        ]));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}
