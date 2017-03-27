<?php

namespace JP\Sistema\Controller;

use Silex\Application;
use Silex\Api\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use \Doctrine\ORM\EntityManager;
use JP\Sistema\Service\ResultaDoervice;

class ProdutoController implements ControllerProviderInterface
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function connect(Application $app)
    {
        $ctrl = $app['controllers_factory'];

        $app['produto_service'] = function () {
            return new \JP\Sistema\Service\ProdutoService($this->em);
        };
        //aplicacao
        $ctrl->get('/', function () use ($app) {
            return $app['twig']->render('produto_inicio.twig');
        })->bind('indexProduto');

        $ctrl->get('/incluir', function (Request $req) use ($app) {
            return $app['twig']->render('produto_cadastro.twig', array('produto'=>null));
        })->bind('incluirProduto');

        $ctrl->get('/alterar/{id}', function ($id) use ($app) {
            $srv = $app['produto_service'];
            $produto = $srv->findById($id);
            return $app['twig']->render('produto_cadastro.twig', array('produto'=>$produto));
        })->bind('alterarProduto')
        ->assert('id', '\d+');

        $ctrl->post('/gravar', function (Request $req) use ($app) {
            $dados = $req->request->all();
            $srv = $app['produto_service'];
            $produto = $srv->save($dados);
            return $app->redirect($app['url_generator']->generate('listarProdutoHtml'));
        })->bind('gravarProduto');

        $ctrl->get('/excluir/{id}', function ($id) use ($app) {
            $srv = $app['produto_service'];
            $resultado = $srv->delete($id);
            return $app['twig']->render('produto_lista.twig', array('produtos'=>$resultado));
        })->bind('excluirProduto')
        ->assert('id', '\d+');

        $ctrl->get('/listar/html', function () use ($app) {
            return $app['twig']->render('produto_lista.twig', ['produtos'=>$app['produto_service']->fetchall()]);
        })->bind('listarProdutoHtml');

        $ctrl->get('/listar/paginado/{qtd}', function ($qtd) use ($app) {
            $srv = $app['produto_service'];
            $resultado = $srv->fetchLimit($qtd);
            return $app->json($resultado);
        })->bind('listarProdutoPaginado')
        ->assert('id', '\d+')
        ->value('qtd', 5); //limite padrao;
        
        //api
        $ctrl->get('/api/listar/json', function () use ($app) {
            $srv = $app['produto_service'];
            $resultado = $srv->fetchall();
            return $app->json($resultado);
        })->bind('listarProdutoJson');

        $ctrl->get('/api/listar/{id}', function ($id) use ($app) {
            $srv = $app['produto_service'];
            $resultado = $srv->findById($id);
            return $app->json($resultado);
        })->bind('listarProdutoIdJson');

        $ctrl->post('/api/inserir', function (Request $req) use ($app) {
            $dados = $req->request->all();
            $srv = $app['produto_service'];
            $resultado = $srv->save($dados);
            return $app->json($resultado);
        })->bind('inserirProdutoJson');

        $ctrl->put('/api/atualizar/{id}', function (Request $req, $id) use ($app) {
            $dados = $req->request->all();
            $srv = $app['produto_service'];
            $resultado = $srv->save($dados);
            return $app->json($resultado);
        })->bind('atualizarProdutoJson');

        $ctrl->delete('/api/apagar/{id}', function ($id) use ($app) {
            $srv = $app['produto_service'];
            $resultado = $srv->delete($id);
            return $app->json($resultado);
        })->bind('apagarProdutoJson');

        return $ctrl;
    }
}
