<?php

namespace JP\Sistema\Service;

use \Doctrine\ORM\EntityManager;
use \Doctrine\ORM\Query;
use JP\Sistema\Entity\TagEntity;
use Doctrine\ORM\Tools\Pagination\Paginator;

class TagService
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function save(array $dados)
    {
        if (!isset($dados['seqTag'])) {
            $tag = new TagEntity();
            $tag->setDescricao($dados['nomTag']);
            $this->em->persist($tag);
        } else {
            //Nao consulta. Cria apenas uma referencia ao objeto que sera persistido
            $tag = $this->em->getReference('\JP\Sistema\Entity\TagEntity', $dados['seqTag']);
            $tag->setNome($dados['nomTag']);
        }
        $this->em->flush();
        return $this->toArray($tag);
    }

    public function delete(int $id)
    {
        $tag = $this->em->getReference('\JP\Sistema\Entity\TagEntity', $id);
        $this->em->remove($tag);
        $this->em->flush();
        return $this->toArray($tag);
    }

    public function fetchall()
    {
        //Não usei o findAll porque ele retorna um objetivo Entity. Quero um array para transformar em JSON
        $tags = $this->em->createQuery('select t from \JP\Sistema\Entity\TagEntity t')
                         ->getArrayResult();
        return $tags;
    }

    public function fetchLimit(int $qtd)
    {
        $tags = $this->em->createQuery('select t from \JP\Sistema\Entity\TagEntity t')
                         ->setMaxResults($qtd)
                         ->getArrayResult();
        return $tags;
    }

    public function findById(int $id)
    {
        $tag = $this->em->createQuery('select t from \JP\Sistema\Entity\TagEntity t where t.id = :id')
                        ->setParameter('id', $id)
                        ->getArrayResult();
        return $tag;
    }

    public function toArray(TagEntity $tag)
    {
        return  array(
            'id' => $tag->getId(),
            'descricao' => $tag->getDescricao() ,
            );
    }
}
