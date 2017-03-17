<?php

namespace JP\Sistema\Service;

use JP\Sistema\Entity\ClienteEntity;
use JP\Sistema\Mapper\ClienteMapper;

class ClienteService
{
    private $ent;
    private $map;

    public function __construct(ClienteEntity $ent, ClienteMapper $map)
    {
        $this->ent = $ent;
        $this->map = $map;
    }

    public function save(array $dados)
    {
        $this->ent->setId($dados['seqCliente']);
        $this->ent->setNome($dados['nomCliente']);
        $this->ent->setEmail($dados['emlCliente']);
        return $this->map->gravar($this->ent);
    }

    public function findById(int $id)
    {
        return $this->map->listar($id);
    }

    public function delete(int $id)
    {
        return $this->map->excluir($id);
    }

    public function fetchall()
    {
        return $this->map->listar();
    }
}
