<?php
require __DIR__.'/../bootstrap.php';

use Symfony\Component\HttpFoundation\Response;

$app->get('/', function () use ($app) {
    return $app['twig']->render('inicio.twig');
})->bind('inicio');

$app->mount('/cliente', new JP\Sistema\Controller\ClienteController($em));
$app->mount('/produto', new JP\Sistema\Controller\ProdutoController($em));
$app->mount('/categoria', new JP\Sistema\Controller\CategoriaController($em));
$app->mount('/tag', new JP\Sistema\Controller\TagController($em));

$app->run();
