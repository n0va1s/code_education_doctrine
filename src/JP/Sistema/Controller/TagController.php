<?php

namespace JP\Sistema\Controller;

use Silex\Application;
use Silex\Api\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManager;
use JP\Sistema\Service\TagService;

class TagController implements ControllerProviderInterface
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function connect(Application $app)
    {
        $ctrl = $app['controllers_factory'];

        $app['tag_service'] = function () {
            return new \JP\Sistema\Service\TagService($this->em);
        };
        //aplicacao
        $ctrl->get('/', function () use ($app) {
            return $app['twig']->render('tag_inicio.twig');
        })->bind('indexTag');

        //api
        $ctrl->get('/api/listar/json', function () use ($app) {
            $srv = $app['tag_service'];
            $tags = $srv->fetchall();
            return $app->json($tags);
        })->bind('listarTagJson');

        $ctrl->get('/api/listar/{id}', function ($id) use ($app) {
            $srv = $app['tag_service'];
            $tags = $srv->findById($id);
            return $app->json($tags);
        })->bind('listarTagIdJson')
        ->assert('id', '\d+');

        $ctrl->post('/api/inserir', function (Request $req) use ($app) {
            $dados = $req->request->all();
            $srv = $app['cliente_service'];
            $tags = $srv->insert($dados);
            return $app->json($tags);
        })->bind('inserirTagJson');

        $ctrl->put('/api/atualizar/{id}', function (Request $req, $id) use ($app) {
            $dados = $req->request->all();
            $srv = $app['tag_service'];
            $tags = $srv->update($id, $dados);
            return $app->json($tags[$id]);
        })->bind('atualizarTagJson')
        ->assert('id', '\d+');

        $ctrl->delete('/api/apagar/{id}', function ($id) use ($app) {
            $srv = $app['tag_service'];
            $tags = $srv->delete($id);
            return $app->json($tags[$id]);
        })->bind('apagarTagJson')
        ->assert('id', '\d+');

        return $ctrl;
    }
}
