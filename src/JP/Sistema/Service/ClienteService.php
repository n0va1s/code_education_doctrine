<?php

namespace JP\Sistema\Service;

use \Doctrine\ORM\EntityManager;
use \Doctrine\ORM\Query;
use JP\Sistema\Entity\ClienteEntity;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpFoundation\File\UploadedFile as File;

class ClienteService
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function save(array $dados, File $file)
    {
        if (isset($dados['seqCliente'])) {
            $cliente = new ClienteEntity();
            $cliente->setNome($dados['nomCliente']);
            $cliente->setEmail($dados['emlCliente']);
            $cliente->setFoto($file);
            $cliente->setDataCriacao();
            $this->em->persist($cliente);
        } else {
            //Nao consulta. Cria apenas uma referencia ao objeto que sera persistido
            $cliente = $this->em->getReference('\JP\Sistema\Entity\ClienteEntity', $dados['seqCliente']);
            $cliente->setNome($dados['nomCliente']);
            $cliente->setEmail($dados['emlCliente']);
            $cliente->setFoto($file);
            $cliente->setDataCriacao();
        }
        $this->em->flush();
        return $this->toArray($cliente);
    }

    public function delete(int $id)
    {
        $cliente = $this->em->getReference('\JP\Sistema\Entity\ClienteEntity', $id);
        $this->em->remove($cliente);
        $this->em->flush();
        return true;
    }

    public function fetchall()
    {
        //Não usei o findAll porque ele retorna um objetivo Entity. Quero um array para transformar em JSON
        $clientes = $this->em->createQuery('select c from \JP\Sistema\Entity\ClienteEntity c')
                         ->getArrayResult();
        return $clientes;
    }

    public function fetchLimit(int $qtd)
    {
        $clientes = $this->em->createQuery('select c from \JP\Sistema\Entity\ClienteEntity c')
                   ->setMaxResults($qtd)
                   ->getArrayResult();
        return $clientes;
    }

    public function findById(int $id)
    {
        $cliente = $this->em->createQuery('select c from \JP\Sistema\Entity\ClienteEntity c where c.id = :id')
                   ->setParameter('id', $id)
                   ->getSingleResult(Query::HYDRATE_ARRAY);
        return $cliente;
    }

    public function toArray(ClienteEntity $cliente)
    {
        return  array(
            'id' => $cliente->getId(),
            'nome' => $cliente->getNome() ,
            'email' => $cliente->getEmail(),
            'foto' => $cliente->getFoto(),
            'dataCriacao' => $cliente->getDataCriacao(),
            );
    }
}
