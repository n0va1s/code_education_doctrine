<?php

namespace JP\Sistema\Service;

use JP\Sistema\Entity\ProdutoEntity;
use JP\Sistema\Mapper\ProdutoMapper;

class ProdutoService
{
    private $ent;
    private $map;

    public function __construct(ProdutoEntity $ent, ProdutoMapper $map)
    {
        $this->ent = $ent;
        $this->map = $map;
    }

    public function save(array $dados)
    {
        $this->ent->setId($dados['seqProduto']);
        $this->ent->setNome($dados['nomProduto']);
        $this->ent->setDescricao($dados['desProduto']);
        
        $valor = str_replace(",", ".", $dados['valProduto']);
        $this->ent->setValor($valor);
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
