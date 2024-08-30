<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Doctrine\Repository;

use Nursery\Domain\Shared\Model\Treatment;
use Nursery\Domain\Shared\Repository\TreatmentRepositoryInterface;

/**
 * @extends AbstractRepository<Treatment>
 */
class TreatmentRepository extends AbstractRepository implements TreatmentRepositoryInterface
{
    protected static function entityClass(): string
    {
        return Treatment::class;
    }

    /**
     * @param list<int> $children
     *
     * @return array<Treatment>|null
     */
    public function searchByFilter(array $children = []): ?array
    {
        $queryBuilder = $this->createQueryBuilder('t');
        $queryBuilder
            ->select('t', 'c', 'd')
            ->join('t.child', 'c')
            ->join('t.dosages', 'd')
            ->where($queryBuilder->expr()->in('c.id', ':childIds'))
            ->setParameter('childIds', $children);

        $query = $queryBuilder->getQuery();

        return $query->getResult();
    }
}
