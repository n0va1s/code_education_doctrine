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
    /**
     * @ORM\ManyToOne(targetEntity="Categoria")
     * @ORM\JoinColumn(name="seq_categoria", referencedColumnName="seq_categoria")
     */
    private $categoria;
    /**
     * @ORM\ManyToOne(targetEntity="Tag")
     * @ORM\JoinColumn(name="seq_tag", referencedColumnName="seq_tag")
     */
    private $tag;

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

    /**
     * Sets the value of valor.
     *
     * @param mixed $valor the valor
     *
     * @return self
     */
    private function _setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    public function getCategoria()
    {
        return $this->categoria;
    }

    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;
        return $this;
    }

    public function getTag()
    {
        return $this->tag;
    }

    public function _setTag($tag)
    {
        $this->tag = $tag;
        return $this;
    }
}
