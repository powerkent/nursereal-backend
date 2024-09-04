<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Doctrine\Repository;

use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Shared\Model\NurseryStructure;
use Nursery\Domain\Shared\Repository\ChildRepositoryInterface;

/**
 * @extends AbstractRepository<Child>
 */
class ChildRepository extends AbstractRepository implements ChildRepositoryInterface
{
    protected static function entityClass(): string
    {
        return Child::class;
    }

    public function searchContractDatesByChildId(int $childId): ?array
    {
        $queryBuilder = $this->createQueryBuilder('c');
        $queryBuilder
            ->select('cd')
            ->join('c.contractDate', 'cd')
            ->where($queryBuilder->expr()->eq('c.id', ':childId'))
            ->setParameter('childId', $childId);

        $query = $queryBuilder->getQuery();

        return $query->getResult();
    }

    public function searchChildrenByNurseryStructure(NurseryStructure $nurseryStructure): ?array
    {
        return $this->findBy(['nurseryStructure' => $nurseryStructure]);
    }
}
