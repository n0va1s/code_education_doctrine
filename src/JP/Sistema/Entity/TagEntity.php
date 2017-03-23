<?php

namespace JP\Sistema\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="Cliente")
 */
class TagEntity
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="seq_tag")
     * @ORM\GeneratedValue
     */
    private $id;
    /**
     * @ORM\Column(type="string", name="nom_tag", length=100)
     */
    private $descricao;
    

    public function getId()
    {
        return $this->id;
    }

    private function _setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getDescricao()
    {
        return $this->descricao;
    }

    private function _setDescricao($descricao)
    {
        $this->descricao = $descricao;

        return $this;
    }
}
