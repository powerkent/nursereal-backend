<?php

declare(strict_types=1);

namespace Nursery\Application\Nursery\Query;

use Nursery\Domain\Nursery\Enum\ActionType;
use Nursery\Domain\Nursery\Model\Action;
use Nursery\Domain\Shared\Query\QueryHandlerInterface;
use Nursery\Domain\Nursery\Repository\ActionRepositoryInterface;

final readonly class FindActionByFiltersQueryHandler implements QueryHandlerInterface
{
    public function __construct(private ActionRepositoryInterface $actionRepository)
    {
    }

    /**
     * @return array<int, Action>|null
     */
    public function __invoke(FindActionByFiltersQuery $query): ?array
    {
        $actions = array_map(function (string $actionType): string {
            return match (ActionType::from($actionType)) {
                ActionType::Activity => Action\Activity::class,
                ActionType::Care => Action\Care::class,
                ActionType::Diaper => Action\Diaper::class,
                ActionType::Lunch => Action\Lunch::class,
                ActionType::Milk => Action\Milk::class,
                ActionType::Presence => Action\Presence::class,
                ActionType::Rest => Action\Rest::class,
                ActionType::Treatment => Action\Treatment::class,
            };
        }, $query->filters['actions']);

        return $this->actionRepository->searchByFilter(
            startDateTime: $query->filters['startDateTime'],
            endDateTime: $query->filters['endDateTime'],
            children: $query->filters['children'] ?? [],
            actions: $actions,
            nurseryStructures: $query->filters['nurseryStructures'] ?? [],
        );
    }
}
