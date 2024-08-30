<?php

declare(strict_types=1);

namespace Nursery\Application\Nursery\Query;

use Nursery\Domain\Nursery\Enum\ActionType;
use Nursery\Domain\Nursery\Model\Action;
use Nursery\Domain\Shared\Query\QueryHandlerInterface;
use Nursery\Domain\Nursery\Repository\ActionRepositoryInterface;

final readonly class FindActionByChildrenAndActionTypeQueryHandler implements QueryHandlerInterface
{
    public function __construct(private ActionRepositoryInterface $actionRepository)
    {
    }

    /**
     * @return array<int, Action>|null
     */
    public function __invoke(FindActionByChildrenAndActionTypeQuery $query): ?array
    {
        if (empty($query->filters['childrenIds']) && empty($query->filters['actionTypes'])) {
            return $this->actionRepository->searchByFilter();
        }

        if (!empty($query->filters['childrenIds'] && empty($query->filters['actionTypes']))) {
            return $this->actionRepository->searchByFilter($query->filters['childrenIds']);
        }

        $actionTypes = array_map(function (string $actionType): string {
            return match (ActionType::from($actionType)) {
                ActionType::Activity => Action\Activity::class,
                ActionType::Care => Action\Care::class,
                ActionType::Diaper => Action\Diaper::class,
                ActionType::Rest => Action\Rest::class,
                ActionType::Treatment => Action\Treatment::class,
                ActionType::Presence => Action\Presence::class,
            };
        }, $query->filters['actionTypes']);

        return $this->actionRepository->searchByFilter($query->filters['childrenIds'], $actionTypes);
    }
}
