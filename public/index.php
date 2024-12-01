<?php

use DI\Container;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$container = new Container();

AppFactory::setContainer($container);

$app = AppFactory::create();

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
