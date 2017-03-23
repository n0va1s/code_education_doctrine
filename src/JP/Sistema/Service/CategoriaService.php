<?php

namespace JP\Sistema\Service;

use \Doctrine\ORM\EntityManager;
use \Doctrine\ORM\Query;
use JP\Sistema\Entity\CategoriaEntity;
use Doctrine\ORM\Tools\Pagination\Paginator;

class CategoriaService
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function save(array $dados)
    {
        if (isset($dados['seqCategoria'])) {
            $categoria = new CategoriaEntity();
            $categoria->setDescricao($dados['nomCategoria']);
            $this->em->persist($categoria);
        } else {
            //Nao consulta. Cria apenas uma referencia ao objeto que sera persistido
            $categoria = $this->em->getReference('\JP\Sistema\Entity\CategoriaEntity', $dados['seqCategoria']);
            $categoria->setNome($dados['nomCategoria']);
        }
        $this->em->flush();
        return $this->fetchall();
    }

    public function delete(int $id)
    {
        $categoria = $this->em->getReference('\JP\Sistema\Entity\CategoriaEntity', $id);
        $this->em->remove($categoria);
        $this->em->flush();
        return $this->fetchall();
    }

    public function fetchall()
    {
        //Não usei o findAll porque ele retorna um objetivo Entity. Quero um array para transformar em JSON
        $categorias = $this->em->createQuery('select c from \JP\Sistema\Entity\CategoriaEntity c')
                           ->getArrayResult();
        return $categorias;
    }

    public function fetchLimit(int $qtd)
    {
        $categorias = $this->em->createQuery('select c from \JP\Sistema\Entity\CategoriaEntity c')
                           ->setMaxResults($qtd)
                           ->getArrayResult();
        return $categorias;
    }

    public function findById(int $id)
    {
        $categoria = $this->em->createQuery('select c from \JP\Sistema\Entity\CategoriaEntity c where id = :id')
                          ->setParameter('id', $id)
                          ->getArrayResult();
        return $categoria;
    }

    public function toArray(CategoriaEntity $categoria)
    {
        return  array(
            'id' => $categoria->getId(),
            'descricao' => $categoria->getDescricao() ,
            );
    }
}
