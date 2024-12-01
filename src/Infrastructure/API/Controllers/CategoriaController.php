<?php

namespace App\Infrastructure\API\Controllers;

use App\Application\UseCases\CriarCategoriaUseCase;
use App\Application\UseCases\AtualizarCategoriaUseCase;
use App\Application\UseCases\DeletarCategoriaUseCase;
use App\Domain\Repositories\CategoriaRepositoryInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CategoriaController
{
    private CriarCategoriaUseCase $criarCategoriaUseCase;
    private AtualizarCategoriaUseCase $atualizarCategoriaUseCase;
    private DeletarCategoriaUseCase $deletarCategoriaUseCase;
    private CategoriaRepositoryInterface $categoriaRepository;

    public function __construct(
        CriarCategoriaUseCase $criarCategoriaUseCase,
        AtualizarCategoriaUseCase $atualizarCategoriaUseCase,
        DeletarCategoriaUseCase $deletarCategoriaUseCase,
        CategoriaRepositoryInterface $categoriaRepository
    ) {
        $this->criarCategoriaUseCase = $criarCategoriaUseCase;
        $this->atualizarCategoriaUseCase = $atualizarCategoriaUseCase;
        $this->deletarCategoriaUseCase = $deletarCategoriaUseCase;
        $this->categoriaRepository = $categoriaRepository;
    }

    public function criar(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();

        $categoria = $this->criarCategoriaUseCase->execute($data);

        $response->getBody()->write(json_encode([
            'id' => $categoria->getId(),
            'nome' => $categoria->getNome()
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
            $categoria = $this->atualizarCategoriaUseCase->execute($id, $data);

            $response->getBody()->write(json_encode([
                'id' => $categoria->getId(),
                'nome' => $categoria->getNome()
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
            $this->deletarCategoriaUseCase->execute($id);

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
        $categorias = $this->categoriaRepository->findAll();

        $data = array_map(function ($categoria) {
            return [
                'id' => $categoria->getId(),
                'nome' => $categoria->getNome()
            ];
        }, $categorias);

        $response->getBody()->write(json_encode($data));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }

    public function obter(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'];
        $categoria = $this->categoriaRepository->findById($id);

        if (!$categoria) {
            $response->getBody()->write(json_encode(['error' => 'Categoria não encontrada']));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(404);
        }

        $response->getBody()->write(json_encode([
            'id' => $categoria->getId(),
            'nome' => $categoria->getNome()
        ]));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}
