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
        $produtos = $this->em->createQuery('select p from \JP\Sistema\Entity\ProdutoEntity c')
                   ->getQuery()
                   ->getArrayResult();
        return $produtos;
    }

    public function findById(int $id)
    {
        $cliente = $this->em->createQuery('select p from \JP\Sistema\Entity\ProdutoEntity p where id = :id')
                   ->setParameter('id', $id)
                   ->getQuery()
                   ->getArrayResult();
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
