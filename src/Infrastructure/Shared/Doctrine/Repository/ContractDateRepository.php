<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Doctrine\Repository;

use DateTimeInterface;
use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Shared\Model\ContractDate;
use Nursery\Domain\Shared\Repository\ContractDateRepositoryInterface;

/**
 * @extends AbstractRepository<ContractDate>
 */
class ContractDateRepository extends AbstractRepository implements ContractDateRepositoryInterface
{
    protected static function entityClass(): string
    {
        return ContractDate::class;
    }

    public function searchByDate(DateTimeInterface $start, ?Child $child = null): array
    {
        $connection = $this->getEntityManager()->getConnection();

        $stmt = $connection->prepare(
            'SELECT *
            FROM contract_date cd
            WHERE DATE(cd.start) = :startDate'.(null !== $child ? ' AND cd.child_id = :child' : '')
        );

        $params = [
            'startDate' => $start->format('Y-m-d'),
        ];

        if (null !== $child) {
            $params['child'] = $child->getId();
        }

        $results = $stmt->executeQuery($params);

        return $results->fetchAllAssociative();
    }
}
