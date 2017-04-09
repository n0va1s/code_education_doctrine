<?php

namespace JP\Sistema\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\UploadedFile as File;
use JP\Sistema\Service\ArquivoService;

/**
 * @ORM\Entity
 * @ORM\hasLifeCycleCallbacks
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
    /**
     * @ORM\Column(type="string", name="url_foto", length=255)
     */
    private $foto;
    /**
     * @ORM\Column(type="datetime", name="dat_cadastro", nullable=true)
     */
    private $dataCriacao;


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

    /** @ORM\PrePersist */
    public function setFoto($foto)
    {
        $this->foto = ArquivoService::carregarImagem($foto);
    }

    public function getFoto()
    {
        return $this->foto;
    }

    /** @ORM\PrePersist */
    public function setDataCriacao()
    {
        $this->dataCriacao = new \DateTime();
    }

    public function getDataCriacao()
    {
        return $this->dataCriacao;
    }
}
