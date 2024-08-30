<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\Doctrine\Repository;

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

    public function searchByFilter(array $children = [], array $actionTypes = []): ?array
    {
        $queryBuilder = $this->createQueryBuilder('o')
            ->select('o', 'c')
            ->join('o.children', 'c');

        if (!empty($children)) {
            $queryBuilder->andWhere($queryBuilder->expr()->in('c.id', ':children'))
                ->setParameter('children', $children);
        }

        if (!empty($actionTypes)) {
            $queryBuilder->andWhere($queryBuilder->expr()->orX(
                ...array_map(function ($type) use ($queryBuilder) {
                    return $queryBuilder->expr()->isInstanceOf('o', $type);
                }, $actionTypes)
            ));
        }

        $query = $queryBuilder->getQuery();

        return $query->getResult();
    }
}
