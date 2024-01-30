<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Sorting;
use App\Domain\Interface\SortingRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Sorting>
 *
 * @method Sorting|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sorting|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sorting[]    findAll()
 * @method Sorting[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SortingRepository extends ServiceEntityRepository implements SortingRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sorting::class);
    }

    public function save(Sorting $sorting): void
    {
        $this->getEntityManager()->persist($sorting);
        $this->getEntityManager()->flush();
    }

    public function getById(string $id): ?Sorting
    {
        return $this->find($id);
    }

    public function getByHash(string $hashedData): ?Sorting
    {
        return $this->findOneBy([
            'dataHash' => $hashedData,
        ]);
    }
}
