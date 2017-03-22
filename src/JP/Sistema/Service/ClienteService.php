<?php

namespace JP\Sistema\Service;

use \Doctrine\ORM\EntityManager;
use JP\Sistema\Entity\ClienteEntity;
use Doctrine\ORM\Tools\Pagination\Paginator;

class ClienteService
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function save(array $dados)
    {
        if (isset($dados['seqCliente'])) {
            $cliente = new ClienteEntity();
            $cliente->setNome($dados['nomCliente']);
            $cliente->setEmail($dados['emlCliente']);
            $this->em->persist($cliente);
        } else {
            //Nao consulta. Cria apenas uma referencia ao objeto que sera persistido
            $cliente = $this->em->getReference('\JP\Sistema\Entity\ClienteEntity', $dados['seqCliente']);
            $cliente->setNome($dados['nomCliente']);
            $cliente->setEmail($dados['emlCliente']);
        }
        $this->em->flush();
        return $this->fetchall();
    }

    public function delete(int $id)
    {
        $cliente = $this->em->getReference('\JP\Sistema\Entity\ClienteEntity', $id);
        $this->em->remove($cliente);
        $this->em->flush();
        return $this->fetchall();
    }

    public function fetchall()
    {
        $r = $this->em->getRepository('\JP\Sistema\Entity\ClienteEntity');
        $clientes = $r->findAll();
        return $clientes;
    }

    public function fetchLimit(int $qtd)
    {
        $r = $this->em->getRepository('\JP\Sistema\Entity\ClienteEntity');
        $clientes = $r->findBy(array(), array('id' => 'DESC'), $qtd);
        return $clientes;
    }

    public function findById(int $id)
    {
        $r = $this->em->getRepository('\JP\Sistema\Entity\ClienteEntity');
        $cliente = $r->findOneById($id);
        return $cliente;
    }

    public function toArray(ClienteEntity $cliente)
    {
        return  array(
            'id' => $cliente->getId(),
            'nome' => $cliente->getNome() ,
            'email' => $cliente->getEmail(),
            );
    }
}
