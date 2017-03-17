<?php

namespace JP\Sistema\Mapper;

use \Doctrine\ORM\EntityManager;
use JP\Sistema\Entity\ClienteEntity;

class ClienteMapper
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function gravar(ClienteEntity $cliente)
    {
        if (empty($cliente->getId())) {
            $this->em->persist($cliente);
        } else {
            $c = $this->em->find('\JP\Sistema\Entity\ClienteEntity', $cliente->getId());
            $c->setNome($cliente->getNome());
            $c->setEmail($cliente->getEmail());
        }
        $this->em->flush();
        return $this->listar();
    }

    public function excluir(int $id)
    {
        $cliente = $this->em->find('\JP\Sistema\Entity\ClienteEntity', $id);
        $this->em->remove($cliente);
        $this->em->flush();
        return $this->listar();
    }

    public function listar(int $id = null)
    {
        if (!empty($id)) {
            $query = $this->em->createQuery('select c from \JP\Sistema\Entity\ClienteEntity c where c.id = :id')
            ->setParameter(":id", $id);
            $cliente = $query->getSingleResult();
            return $cliente;
        } else {
            $query = $this->em->createQuery('select c from \JP\Sistema\Entity\ClienteEntity c');
            $clientes = $query->getArrayResult();
            return $clientes;
        }
    }

    public function toArray(ClienteEntity $cliente)
    {
        return  array(
            'id' => $cliente->getId(),
            'nome' => $cliente->getNome() ,
            'email' => $cliente->getEmail(), );
    }
}
