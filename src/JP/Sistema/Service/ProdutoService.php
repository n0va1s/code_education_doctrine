<?php

namespace JP\Sistema\Service;

use \Doctrine\ORM\EntityManager;
use JP\Sistema\Entity\ProdutoEntity;

class ProdutoService
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function save(array $dados)
    {
        if (!isset($dados['seqProduto'])) {
            $produto = new ProdutoEntity();
            $produto->setNome($dados['nomProduto']);
            $produto->setDescricao($dados['desProduto']);
            $produto->setValor(str_replace(",", ".", $dados['valProduto']));
            $this->em->persist($produto);
        } else {
            //Nao consulta. Cria apenas uma referencia ao objeto que sera persistido
            $produto = $this->em->getReference('\JP\Sistema\Entity\ProdutoEntity', $dados['seqProduto']);
            $produto->setNome($dados['nomProduto']);
            $produto->setDescricao($dados['desProduto']);
            $produto->setValor(str_replace(",", ".", $dados['valProduto']));
        }
        $this->em->flush();
        return $this->fetchAll();
    }

    public function delete(int $id)
    {
        $produto = $this->em->getReference('\JP\Sistema\Entity\ProdutoEntity', $id);
        $this->em->remove($produto);
        $this->em->flush();
        return $this->fetchAll();
    }

    public function fetchAll()
    {
        $r = $this->em->getRepository('\JP\Sistema\Entity\ProdutoEntity');
        $produtos = $r->findAll();
        return $produtos;
    }

    public function fetchLimit(int $qtd)
    {
        $r = $this->em->getRepository('\JP\Sistema\Entity\ProdutoEntity');
        $produtos = $r->findBy(array(), array('id' => 'DESC'), $qtd);
        return $produtos;
    }

    public function findById(int $id)
    {
        $r = $this->em->getRepository('\JP\Sistema\Entity\ProdutoEntity');
        $produto = $r->findOneById($id);
        return $produto;
    }

    public function toArray(ProdutoEntity $produto)
    {
        return  array(
            'id' => $produto->getId(),
            'nome' => $produto->getNome() ,
            'descricao' => $produto->getEmail(),
            'valor' => $produto->getValor(),
            );
    }
}
