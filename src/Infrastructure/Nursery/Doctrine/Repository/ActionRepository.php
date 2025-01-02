<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\Doctrine\Repository;

use DateTimeInterface;
use Nursery\Domain\Nursery\Enum\ActionState;
use Nursery\Domain\Nursery\Model\Action;
use Nursery\Domain\Nursery\Repository\ActionRepositoryInterface;
use Nursery\Infrastructure\Shared\Doctrine\Repository\AbstractRepository;

/**
 * @extends AbstractRepository<Action>
 */
class ActionRepository extends AbstractRepository implements ActionRepositoryInterface
{
    protected static function entityClass(): string
    {
        return Action::class;
    }

    public function searchByFilter(
        DateTimeInterface $startDateTime,
        DateTimeInterface $endDateTime,
        ?ActionState $state = null,
        array $children = [],
        array $actions = [],
        array $nurseryStructures = [],
        array $agents = [],
    ): ?array {
        $queryBuilder = $this->createQueryBuilder('o')
            ->select('o, c')
            ->join('o.child', 'c')
            ->andWhere('o.createdAt BETWEEN :startDate AND :endDate')
            ->setParameter('startDate', $startDateTime)
            ->setParameter('endDate', $endDateTime);

        if (null !== $state) {
            $queryBuilder->andWhere('o.state = :state')
                ->setParameter('state', $state->value);
        }

        if (!empty($agents)) {
            $queryBuilder->join('o.agent', 'a')
                ->andWhere('a.uuid IN (:agents)')
                ->setParameter('agents', $agents);
        }

        if (!empty($children)) {
            $queryBuilder->andWhere('c.uuid IN (:children)')
                ->setParameter('children', $children);
        }

        if (!empty($nurseryStructures)) {
            $queryBuilder->join('c.nurseryStructure', 'n')
                ->andWhere('n.uuid IN (:nurseryStructures)')
                ->setParameter('nurseryStructures', $nurseryStructures);
        }

        if (!empty($actions)) {
            $queryBuilder->andWhere($queryBuilder->expr()->orX(
                ...array_map(function ($type) use ($queryBuilder) {
                    return $queryBuilder->expr()->isInstanceOf('o', $type);
                }, $actions)
            ));
        }

        $query = $queryBuilder->getQuery();

        return $query->getResult();
    }
}
