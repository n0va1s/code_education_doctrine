<?php

namespace JP\Sistema\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="Categoria")
 */
class CategoriaEntity
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="seq_categoria")
     * @ORM\GeneratedValue
     */
    private $id;
    /**
     * @ORM\Column(type="string", name="nom_categoria", length=100)
     */
    private $descricao;
    

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
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
}
