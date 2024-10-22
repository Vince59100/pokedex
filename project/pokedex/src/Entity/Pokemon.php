<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PokemonRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity(repositoryClass: PokemonRepository::class)]
#[ApiResource]
class Pokemon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $imagePokedex = null;

    #[ORM\Column(length: 255)]
    private ?string $imageDetail = null;

    #[ORM\Column]
    private ?int $idPokemon = null;

    public function __construct()
    {
        $this->types = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function getImagePokedex(): ?string
    {
        return $this->imagePokedex;
    }

    public function setImagePokedex(string $imagePokedex): static
    {
        $this->imagePokedex = $imagePokedex;
        return $this;
    }

    public function getImageDetail(): ?string
    {
        return $this->imageDetail;
    }

    public function setImageDetail(string $imageDetail): static
    {
        $this->imageDetail = $imageDetail;
        return $this;
    }


    public function getIdPokemon(): ?int
    {
        return $this->idPokemon;
    }

    public function setIdPokemon(int $idPokemon): static
    {
        $this->idPokemon = $idPokemon;
        return $this;
    }
}

