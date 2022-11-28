<?php

namespace App\Application\Schema\DocumentoBundle\Entity;

use App\Application\Schema\DocumentoBundle\Repository\DocumentoRepository;
use App\Application\Schema\TipoDocumentoBundle\Entity\TipoDocumento;
use App\Application\Schema\AutorBundle\Entity\Autor;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DateTime;

/** Info:  */
#[ORM\Table(name: 'documento')]
#[ORM\Entity(repositoryClass: DocumentoRepository::class)]
#[UniqueEntity('id')]
class Documento
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id', type: 'integer', unique: true, nullable: false)]
    private ?int $id = null;

    #[Assert\NotNull]
    #[Assert\NotBlank]
    #[ORM\Column(name: 'titulo', type: 'string', unique: false, nullable: false)]
    private string $titulo;

    #[Assert\NotNull]
    #[Assert\NotBlank]
    #[ORM\Column(name: 'descricao', type: 'string', unique: false, nullable: false)]
    private string $descricao;

    #[ORM\JoinTable(name: 'tipos_documento_documento')]
    #[ORM\JoinColumn(name: 'documento_id', referencedColumnName: 'id', onDelete: 'SET NULL')]
    #[ORM\InverseJoinColumn(name: 'tipodocumento_id', referencedColumnName: 'id')]
    #[ORM\ManyToMany(targetEntity: TipoDocumento::class)]
    private Collection $tiposDocumento;

    #[ORM\JoinTable(name: 'autor_documento')]
    #[ORM\JoinColumn(name: 'documento_id', referencedColumnName: 'id', onDelete: 'SET NULL')]
    #[ORM\InverseJoinColumn(name: 'autor_id', referencedColumnName: 'id')]
    #[ORM\ManyToMany(targetEntity: Autor::class, inversedBy: 'documentos')]
    private Collection $autores;


    public function __construct()
    {
        $this->tiposDocumento = new ArrayCollection();
        $this->autores = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getTitulo(): string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): void
    {
        $this->titulo = $titulo;
    }

    public function getDescricao(): string
    {
        return $this->descricao;
    }

    public function setDescricao(string $descricao): void
    {
        $this->descricao = $descricao;
    }

    public function getTiposDocumento(): Collection
    {
        return $this->tiposDocumento;
    }

    public function setTiposDocumento(Collection $tiposDocumento): void
    {
        $this->tiposDocumento = $tiposDocumento;
    }


    public function getAutores(): Collection
    {
        return $this->autores;
    }

    public function setAutores(Collection $autores): void
    {
        $this->autores = $autores;
    }



}