<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\DTO\Point;
use App\Entity\Location;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Location>
 *
 * @method Location|null find($id, $lockMode = null, $lockVersion = null)
 * @method Location|null findOneBy(array $criteria, array $orderBy = null)
 * @method Location[]    findAll()
 * @method Location[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LocationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Location::class);
    }

    public function save(Location $location, bool $doFlush = true): void
    {
        $entityManager = $this->getEntityManager();

        $entityManager->persist($location);

        if ($doFlush) {
            $entityManager->flush();
        }
    }

    public function getPointById(int $id): ?Point
    {
        return $this->createQueryBuilder('l')
            ->select('l.point')
            ->andWhere('l.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getSingleResult()
        ;
    }
}
