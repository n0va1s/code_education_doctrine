<?php

namespace JP\Sistema\Mapper;

use \Doctrine\ORM\EntityManager;
use JP\Sistema\Entity\ProdutoEntity;

class ProdutoMapper
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function gravar(ProdutoEntity $produto)
    {
        if (empty($produto->getId())) {
            $this->em->persist($produto);
        } else {
            $p = $this->em->find('\JP\Sistema\Entity\ProdutoEntity', $produto->getId());
            $p->setId($produto->getId());
            $p->setNome($produto->getNome());
            $p->setDescricao($produto->getDescricao());
            $p->setValor($produto->getValor());
        }
        $this->em->flush();
        return $this->listar();
    }

    public function excluir(int $id)
    {
        $produto = $this->em->find('\JP\Sistema\Entity\ProdutoEntity', $id);
        $this->em->remove($produto);
        $this->em->flush();
        return $this->listar();
    }

    public function listar(int $id = null)
    {
        if (!empty($id)) {
            $query = $this->em->createQuery('select p from \JP\Sistema\Entity\ProdutoEntity p where p.id = :id')
            ->setParameter(":id", $id);
            $produto = $query->getSingleResult();
            return $produto;
        } else {
            $query = $this->em->createQuery('select p from \JP\Sistema\Entity\ProdutoEntity p');
            $produtos = $query->getArrayResult();
            return $produtos;
        }
    }

    public function toArray(ProdutoEntity $produto)
    {
        return  array(
            'id' => $produto->getId(),
            'nome' => $produto->getNome() ,
            'descricao' => $produto->getDescricao(),
            'valor' => $produto->getValor(), );
    }
}
