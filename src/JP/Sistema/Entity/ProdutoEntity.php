<?php

namespace JP\Sistema\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="Produto")
 */
class ProdutoEntity
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="seq_produto")
     * @ORM\GeneratedValue
     */
    private $id;
     /**
     * @ORM\Column(type="string", name="nom_produto", length=100)
     */
    private $nome;
      /**
     * @ORM\Column(type="text", name="des_produto")
     */
    private $descricao;
     /**
     * @ORM\Column(type="decimal", precision=10, scale=2, name="val_produto")
     */
    private $valor;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }

    public function getDescricao()
    {
        return $this->descricao;
    }

    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    public function getValor()
    {
        return $this->valor;
    }

    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }
}
