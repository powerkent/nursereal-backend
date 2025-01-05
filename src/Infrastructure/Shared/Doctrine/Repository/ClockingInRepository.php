<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Doctrine\Repository;

use DateTimeInterface;
use Nursery\Domain\Shared\Model\ClockingIn;
use Nursery\Domain\Shared\Repository\ClockingInRepositoryInterface;

/**
 * @extends AbstractRepository<ClockingIn>
 */
class ClockingInRepository extends AbstractRepository implements ClockingInRepositoryInterface
{
    protected static function entityClass(): string
    {
        return ClockingIn::class;
    }

    public function searchByFilter(
        DateTimeInterface $startDateTime,
        DateTimeInterface $endDateTime,
        array $nurseryStructures = [],
        array $agents = [],
    ): ?array {
        $queryBuilder = $this->createQueryBuilder('o')
            ->select('o, a')
            ->join('o.agent', 'a')
            ->andWhere('o.startDateTime BETWEEN :startDate AND :endDate')
            ->andWhere('n.uuid IN (:nurseryStructures)')
            ->setParameter('startDate', $startDateTime)
            ->setParameter('endDate', $endDateTime);

        if (!empty($nurseryStructures)) {
            $queryBuilder
                ->join('a.nurseryStructures', 'n')
                ->andWhere('n.uuid IN (:nurseryStructures)')
                ->setParameter('nurseryStructures', $nurseryStructures);
        }

        if (!empty($agents)) {
            $queryBuilder
                ->andWhere('a.uuid IN (:agents)')
                ->setParameter('agents', $agents);
        }

        $query = $queryBuilder->getQuery();

        return $query->getResult();
    }
}
