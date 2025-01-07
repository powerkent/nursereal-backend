<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\Doctrine\Repository;

use DateTimeInterface;
use Exception;
use Nursery\Domain\Nursery\Enum\ActionState;
use Nursery\Domain\Nursery\Enum\ActionType;
use Nursery\Domain\Nursery\Model\Action;
use Nursery\Domain\Nursery\Repository\ActionRepositoryInterface;
use Nursery\Infrastructure\Shared\Doctrine\Repository\AbstractRepository;
use function array_diff;

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
            ->andWhere('COALESCE(o.updatedAt, o.createdAt) BETWEEN :startDate AND :endDate')
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
            $completedActions = [];
            foreach ($actions as $key => $action) {
                $completedAction = true;
                switch ($action) {
                    case Action\Presence::class:
                        $class = 'Nursery\Domain\Nursery\Model\Action\Presence';
                        break;
                    case Action\Milk::class:
                        $class = 'Nursery\Domain\Nursery\Model\Action\Milk';
                        break;
                    case Action\Rest::class:
                        $class = 'Nursery\Domain\Nursery\Model\Action\Rest';
                        break;
                    case Action\Lunch::class:
                        $class = 'Nursery\Domain\Nursery\Model\Action\Lunch';
                        break;
                    case Action\Activity::class:
                        $class = 'Nursery\Domain\Nursery\Model\Action\Activity';
                        break;
                    default:
                        $completedAction = false;
                        $class = null;
                        break;
                }
                $completedActions[] = $action;
                if ($completedAction && null !== $class) {
                    $queryBuilder
                        ->leftJoin($class, "h$key", 'WITH', "h$key.id = o.id")
                        ->andWhere("h$key.startDateTime BETWEEN :startDate AND :endDate")
                        ->setParameter('startDate', $startDateTime)
                        ->setParameter('endDate', $endDateTime);
                }
            }

            $queryBuilder->andWhere($queryBuilder->expr()->orX(
                ...array_map(function ($type) use ($queryBuilder) {
                    return $queryBuilder->expr()->isInstanceOf('o', $type);
                }, array_diff($actions, $completedActions))
            ));

        }

        $query = $queryBuilder->getQuery();

        return $query->getResult();
    }

    public function searchByType(ActionType $type): array
    {
        $class =  match ($type) {
            ActionType::Activity => Action\Activity::class,
            ActionType::Care => Action\Care::class,
            ActionType::Diaper => Action\Diaper::class,
            ActionType::Lunch => Action\Lunch::class,
            ActionType::Milk => Action\Milk::class,
            ActionType::Presence => Action\Presence::class,
            ActionType::Rest => Action\Rest::class,
            ActionType::Treatment => Action\Treatment::class,
            ActionType::Action => throw new Exception('Unable to process action type.'),
        };

        $queryBuilder = $this->createQueryBuilder('o')
            ->select('o, c')
            ->join($class, 'c')
            ->andWhere('o.type = :type')
            ->setParameter('type', $type->value);

        $query = $queryBuilder->getQuery();

        return $query->getResult();
    }
}
