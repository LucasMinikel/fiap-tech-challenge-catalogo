<?php

use DI\Bridge\Slim\Bridge;
use DI\ContainerBuilder;
use Dotenv\Dotenv;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();


$containerBuilder = new ContainerBuilder();
$dependencies = require __DIR__ . '/../dependencies.php';
$dependencies($containerBuilder);

$container = $containerBuilder->build();
$app = Bridge::create($container);

$app->post('/produtos', [\App\Infrastructure\API\Controllers\ProdutoController::class, 'criar']);
$app->put('/produtos/{id}', [\App\Infrastructure\API\Controllers\ProdutoController::class, 'atualizar']);
$app->delete('/produtos/{id}', [\App\Infrastructure\API\Controllers\ProdutoController::class, 'deletar']);
$app->get('/produtos', [\App\Infrastructure\API\Controllers\ProdutoController::class, 'listar']);
$app->get('/produtos/{id}', [\App\Infrastructure\API\Controllers\ProdutoController::class, 'obter']);

$app->post('/categorias', [\App\Infrastructure\API\Controllers\CategoriaController::class, 'criar']);
$app->put('/categorias/{id}', [\App\Infrastructure\API\Controllers\CategoriaController::class, 'atualizar']);
$app->delete('/categorias/{id}', [\App\Infrastructure\API\Controllers\CategoriaController::class, 'deletar']);
$app->get('/categorias', [\App\Infrastructure\API\Controllers\CategoriaController::class, 'listar']);
$app->get('/categorias/{id}', [\App\Infrastructure\API\Controllers\CategoriaController::class, 'obter']);

$app->run();
