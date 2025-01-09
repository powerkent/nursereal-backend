<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Doctrine\Repository;

use Nursery\Domain\Shared\Model\NurseryStructure;
use Nursery\Domain\Shared\Model\ShiftType;
use Nursery\Domain\Shared\Repository\ShiftTypeRepositoryInterface;

/**
 * @extends AbstractRepository<ShiftType>
 */
class ShiftTypeRepository extends AbstractRepository implements ShiftTypeRepositoryInterface
{
    protected static function entityClass(): string
    {
        return ShiftType::class;
    }

    public function searchShiftTypesByNurseryStructure(NurseryStructure $nurseryStructure): ?array
    {
        $queryBuilder = $this->createQueryBuilder('st');
        $queryBuilder
            ->select('st')
            ->join('st.nurseryStructures', 'ns')
            ->where('ns.id = :nurseryStructureId')
            ->setParameter('nurseryStructureId', $nurseryStructure->getId());

        $query = $queryBuilder->getQuery();

        return $query->getResult();
    }
}
