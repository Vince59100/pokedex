<?php

namespace App\Repository;

use App\Entity\Pokemon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends ServiceEntityRepository<Pokemon>
 */
class PokemonRepository extends ServiceEntityRepository
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, ManagerRegistry $registry)
    {
        $this->entityManager = $entityManager;
        parent::__construct($registry, Pokemon::class);
    }

    public function getAll(): array
    {
        return $this->entityManager->getRepository(Pokemon::class)->findAll();
    }

    public function add(Pokemon $pokemon): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($pokemon);
        $entityManager->flush();
    }

    public function delete(Pokemon $pokemon): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->remove($pokemon);
        $entityManager->flush();
    }

    public function update(Pokemon $pokemon): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($pokemon);
        $entityManager->flush();
    }

}
