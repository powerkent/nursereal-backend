<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\Pagination;
use DateTimeImmutable;
use Nursery\Application\Nursery\Query\FindActionByFiltersQuery;
use Nursery\Domain\Nursery\Enum\ActionState;
use Nursery\Domain\Nursery\Model\Action;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Provider\AbstractCollectionProvider;
use Nursery\Infrastructure\Nursery\ApiPlatform\Resource\Action\ActionResource;
use Nursery\Infrastructure\Nursery\ApiPlatform\Resource\Action\ActionResourceFactory;

/**
 * @extends AbstractCollectionProvider<Action, ActionResource>
 */
class ActionCollectionProvider extends AbstractCollectionProvider
{
    public function __construct(
        private QueryBusInterface $queryBus,
        private ActionResourceFactory $actionResourceFactory,
        Pagination $pagination,
    ) {
        parent::__construct($pagination);
    }

    public function collection(Operation $operation, array $uriVariables = [], array $filters = [], array $context = []): iterable
    {
        $filters = [];

        if ([] !== $actions = (array) ($context['filters']['actions'] ?? [])) {
            $filters['actions'] = $actions;
        }

        if ([] !== $children = (array) ($context['filters']['children'] ?? [])) {
            $filters['children'] = $children;
        }

        if ([] !== $nurseryStructures = (array) ($context['filters']['nursery_structures'] ?? [])) {
            $filters['nurseryStructures'] = $nurseryStructures;
        }

        if (null !== $state = ($context['filters']['state'] ?? null)) {
            $filters['state'] = ActionState::from($state);
        }

        $filters['startDateTime'] = new DateTimeImmutable($context['filters']['start_date_time']);
        $filters['endDateTime'] = new DateTimeImmutable($context['filters']['end_date_time']);

        return $this->queryBus->ask(new FindActionByFiltersQuery($filters));
    }

    protected function toResource(object $model): object
    {
        return $this->actionResourceFactory->fromModel($model);
    }
}
