<?php
namespace App\Repository;

use App\Entity\Viaje;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Viaje>
 */
class ViajeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Viaje::class);
    }

    /**
     * Find viajes for a given usuario id ordered by createdAt desc
     * @return Viaje[]
     */
    public function findByUsuarioId(int $usuarioId): array
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.usuario = :uid')
            ->setParameter('uid', $usuarioId)
            ->orderBy('v.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
