<?php

namespace JP\Sistema\Controller;

use Silex\Application;
use Silex\Api\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManager;
use JP\Sistema\Service\CategoriaService;

class CategoriaController implements ControllerProviderInterface
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function connect(Application $app)
    {
        $ctrl = $app['controllers_factory'];

        $app['categoria_service'] = function () {
            return new \JP\Sistema\Service\CategoriaService($this->em);
        };
        //aplicacao
        $ctrl->get('/', function () use ($app) {
            return $app['twig']->render('categoria_inicio.twig');
        })->bind('indexCategoria');

        //api
        $ctrl->get('/api/listar/json', function () use ($app) {
            $srv = $app['categoria_service'];
            $categorias = $srv->fetchall();
            return $app->json($categorias);
        })->bind('listarCategoriaJson');

        $ctrl->get('/api/listar/{id}', function ($id) use ($app) {
            $srv = $app['categoria_service'];
            $categorias = $srv->findById($id);
            return $app->json($categorias);
        })->bind('listarCategoriaIdJson')
        ->assert('id', '\d+');

        $ctrl->post('/api/inserir', function (Request $req) use ($app) {
            $dados = $req->request->all();
            $srv = $app['cliente_service'];
            $categorias = $srv->insert($dados);
            return $app->json($categorias);
        })->bind('inserirCategoriaJson');

        $ctrl->put('/api/atualizar/{id}', function (Request $req, $id) use ($app) {
            $dados = $req->request->all();
            $srv = $app['categoria_service'];
            $categorias = $srv->update($id, $dados);
            return $app->json($categorias[$id]);
        })->bind('atualizarCategoriaJson')
        ->assert('id', '\d+');

        $ctrl->delete('/api/apagar/{id}', function ($id) use ($app) {
            $srv = $app['categoria_service'];
            $categorias = $srv->delete($id);
            return $app->json($categorias[$id]);
        })->bind('apagarCategoriaJson')
        ->assert('id', '\d+');

        return $ctrl;
    }
}
