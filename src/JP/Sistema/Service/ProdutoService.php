<?php

namespace JP\Sistema\Service;

use \Doctrine\ORM\EntityManager;
use JP\Sistema\Entity\CategoriaEntity;
use JP\Sistema\Entity\ProdutoEntity;
use JP\Sistema\Entity\TagEntity;

class ProdutoService
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function save(array $dados)
    {
        if (!isset($dados['seqProduto'])) {
            $produto = new ProdutoEntity();
            $produto->setNome($dados['nomProduto']);
            $produto->setDescricao($dados['desProduto']);
            $produto->setValor(str_replace(",", ".", $dados['valProduto']));
            if (isset($dados['seqCategoria'])) {
                $categoria = $this->em->getReference('\JP\Sistema\Entity\CategoriaEntity', $dados['seqCategoria']);
                $categoria->setId($dados['seqCategoria']);
                $this->em->persist($categoria);
                //Relacionamento
                $produto->setCategoria($categoria);
            }
            if (isset($dados['seqTag'])) {
                $arrTag = explode(",", $dados['seqTag']);
                foreach ($arrTag as $seqTag) {
                    $tag = $this->em->getReference('\JP\Sistema\Entity\TagEntity', $seqTag);
                    $tag->setId($seqTag);
                    $produto->addTag($tag);
                    $this->em->persist($tag);
                }
            }
            $this->em->persist($produto);
        } else {
            //Nao consulta. Cria apenas uma referencia ao objeto que sera persistido
            $produto = $this->em->getReference('\JP\Sistema\Entity\ProdutoEntity', $dados['seqProduto']);
            $produto->setNome($dados['nomProduto']);
            $produto->setDescricao($dados['desProduto']);
            $produto->setValor(str_replace(",", ".", $dados['valProduto']));
        }
        $this->em->flush();
        return $this->toArray($produto);
    }

    public function delete(int $id)
    {
        $produto = $this->em->getReference('\JP\Sistema\Entity\ProdutoEntity', $id);
        $this->em->remove($produto);
        $this->em->flush();
        return true;
    }

    public function fetchAll()
    {
        $produtos = $this->em->createQuery('select p from \JP\Sistema\Entity\ProdutoEntity p')
                   ->getArrayResult();
        return $produtos;
    }

    public function fetchLimit(int $qtd)
    {
        $produtos = $this->em->createQuery('select p from \JP\Sistema\Entity\ProdutoEntity p')
                   ->setMaxResults($qtd)
                   ->getArrayResult();
        return $produtos;
    }

    public function findById(int $id)
    {
        $produto = $this->em->createQuery('select p from \JP\Sistema\Entity\ProdutoEntity p where p.id = :id')
                   ->setParameter('id', $id)
                   ->getArrayResult();
        return $produto;
    }

    public function toArray(ProdutoEntity $produto)
    {
        return  array(
            'id' => $produto->getId(),
            'nome' => $produto->getNome() ,
            'descricao' => $produto->getDescricao(),
            'valor' => $produto->getValor(),
            );
    }
}
