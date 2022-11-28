<?php

namespace App\Application\Schema\AutorBundle\Entity;

use App\Application\Schema\AutorBundle\Repository\AutorRepository;
use App\Application\Schema\DocumentoBundle\Entity\Documento;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DateTime;

/** Info: Classe Autor */
#[ORM\Table(name: 'autor')]
#[ORM\Entity(repositoryClass: AutorRepository::class)]
#[UniqueEntity('id')]
class Autor
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id', type: 'integer', unique: true, nullable: false)]
    private ?int $id = null;

    #[Assert\NotNull]
    #[Assert\NotBlank]
    #[ORM\Column(name: 'nome', type: 'string', unique: false, nullable: false)]
    private string $nome;

    #[Assert\NotNull]
    #[Assert\NotBlank]
    #[ORM\Column(name: 'sobrenome', type: 'string', unique: false, nullable: false)]
    private string $sobrenome;

    #[Assert\NotNull]
    #[Assert\NotBlank]
    #[ORM\Column(name: 'email', type: 'string', unique: false, nullable: false)]
    private string $email;

    #[ORM\ManyToMany(targetEntity: Autor::class, mappedBy: 'revisores')]
    private Collection $listRevisores;

    #[ORM\JoinTable(name: 'autor_revisores')]
    #[ORM\JoinColumn(name: 'revisores_id', referencedColumnName: 'id', onDelete: 'SET NULL')]
    #[ORM\InverseJoinColumn(name: 'autor_id', referencedColumnName: 'id')]
    #[ORM\ManyToMany(targetEntity: Autor::class, inversedBy: 'listRevisores')]
    private Collection $revisores;

    #[ORM\ManyToMany(targetEntity: Documento::class, mappedBy: 'autores')]
    private Collection $documentos;


    public function __construct()
    {
        $this->listRevisores = new ArrayCollection();
        $this->revisores = new ArrayCollection();
        $this->documentos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getNome(): string
    {
        return $this->nome;
    }

    public function setNome(string $nome): void
    {
        $this->nome = $nome;
    }

    public function getSobrenome(): string
    {
        return $this->sobrenome;
    }

    public function setSobrenome(string $sobrenome): void
    {
        $this->sobrenome = $sobrenome;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getListRevisores(): Collection
    {
        return $this->listRevisores;
    }

    public function setListRevisores(Collection $listRevisores): void
    {
        $this->listRevisores = $listRevisores;
    }

    public function getRevisores(): Collection
    {
        return $this->revisores;
    }

    public function setRevisores(Collection $revisores): void
    {
        $this->revisores = $revisores;
    }


    public function getDocumentos(): Collection
    {
        return $this->documentos;
    }

    public function setDocumentos(Collection $documentos): void
    {
        $this->documentos = $documentos;
    }



}