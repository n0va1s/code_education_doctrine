<?php

namespace JP\Sistema\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="Cliente")
 */
class ClienteEntity
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="seq_cliente")
     * @ORM\GeneratedValue
     */
    private $id;
    /**
     * @ORM\Column(type="string", name="nom_cliente", length=100)
     */
    private $nome;
    /**
     * @ORM\Column(type="string", name="eml_cliente", length=100)
     */
    private $email;

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

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }
}
