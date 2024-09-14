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

    public function searchByDate(Child $child, DateTimeInterface $start): array
    {
        $connection = $this->getEntityManager()->getConnection();

        $stmt = $connection->prepare(
            'SELECT *
            FROM contract_date cd
            WHERE cd.child_id = :childId
            AND DATE(cd.start) = :startDate'
        );

        $results = $stmt->executeQuery([
            'childId'   => $child->getId(),
            'startDate' => $start->format('Y-m-d'),
        ]);

        return $results->fetchAllAssociative();
    }
}
