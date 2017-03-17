<?php

namespace JP\Sistema\Controller;

use Silex\Application;
use Silex\Api\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManager;
use JP\Sistema\Service\ClienteService;
use JP\Sistema\Entity\ClienteEntity;
use JP\Sistema\Mapper\ClienteMapper;

class ClienteController implements ControllerProviderInterface
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function connect(Application $app)
    {
        $ctrl = $app['controllers_factory'];

        $app['cliente_service'] = function () {
            $ent = new \JP\Sistema\Entity\ClienteEntity();
            $map = new \JP\Sistema\Mapper\ClienteMapper($this->em);
            return new \JP\Sistema\Service\ClienteService($ent, $map);
        };
        //aplicacao
        $ctrl->get('/', function () use ($app) {
            return $app['twig']->render('cliente_inicio.twig');
        })->bind('indexCliente');

        $ctrl->get('/incluir', function () use ($app) {
            return $app['twig']->render('cliente_cadastro.twig', array('cliente'=>null));
        })->bind('incluirCliente');

        $ctrl->get('/alterar/{id}', function (Request $req, $id) use ($app) {
            $dados = $req->request->all();
            $srv = $app['cliente_service'];
            $cliente = $srv->findById($id);
            return $app['twig']->render('cliente_cadastro.twig', array('cliente'=>$cliente));
        })->bind('alterarCliente');

        $ctrl->post('/gravar', function (Request $req) use ($app) {
            $dados = $req->request->all();
            $srv = $app['cliente_service'];
            $clientes = $srv->save($dados);
            return $app['twig']->render('cliente_lista.twig', array('clientes'=>$clientes));
        })->bind('gravarCliente');

        $ctrl->get('/excluir/{id}', function ($id) use ($app) {
            $srv = $app['cliente_service'];
            $clientes = $srv->delete($id);
            return $app['twig']->render('cliente_lista.twig', array('clientes'=>$clientes));
        })->bind('excluirCliente');

        $ctrl->get('/listar/html', function () use ($app) {
            return $app['twig']->render('cliente_lista.twig', ['clientes'=>$app['cliente_service']->fetchall()]);
        })->bind('listarClienteHtml');

        $ctrl->get('/listar/json', function () use ($app) {
            return new Response($app->json($app['cliente_service']->fetchall()), 201);
        })->bind('listarClienteJson');

        //api
        $ctrl->get('/api/listar/json', function () use ($app) {
            $srv = $app['cliente_service'];
            $clientes = $srv->fetchall();
            return $app->json($clientes);
        })->bind('listarClienteJson');

        $ctrl->get('/api/listar/{id}', function ($id) use ($app) {
            $srv = $app['cliente_service'];
            $clientes = $srv->fetchall();
            $chave = array_search($id, array_column($clientes, 'id'));
            return $app->json($clientes[$chave]);
        })->bind('listarClienteIdJson');

        $ctrl->post('/api/inserir', function (Request $req) use ($app) {
            $dados = $req->request->all();
            $srv = $app['cliente_service'];
            $clientes = $srv->insert($dados);
            return $app->json($clientes);
        })->bind('inserirClienteJson');

        $ctrl->put('/api/atualizar/{id}', function (Request $req, $id) use ($app) {
            $dados = $req->request->all();
            $srv = $app['cliente_service'];
            $clientes = $srv->update($id, $dados);
            return $app->json($clientes[$chave]);
        })->bind('atualizarClienteJson');

        $ctrl->delete('/api/apagar/{id}', function ($id) use ($app) {
            $srv = $app['cliente_service'];
            $clientes = $srv->delete($id);
            return $app->json($clientes[$id]);
        })->bind('apagarClienteJson');

        return $ctrl;
    }
}
