<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\Pagination;
use Nursery\Application\Nursery\Query\FindActionByChildrenAndActionTypeQuery;
use Nursery\Domain\Nursery\Model\Action;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Provider\AbstractCollectionProvider;
use Nursery\Infrastructure\Nursery\ApiPlatform\Resource\Action\ActionResource;
use Nursery\Infrastructure\Nursery\ApiPlatform\Resource\Action\ActionResourceFactory;
use function array_map;
use function explode;

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

        if ([] !== $actions = (array) ($context['filters']['action'] ?? [])) {
            $filters['actionTypes'] = $actions;
        }

        if ([] !== $children = (array) ($context['filters']['children'] ?? [])) {
            $childrenIds = array_map(fn (string $name): int => (int) explode(':', $name)[0], $children);
            $filters['childrenIds'] = $childrenIds;
        }

        return $this->queryBus->ask(new FindActionByChildrenAndActionTypeQuery($filters));
    }

    protected function toResource(object $model): object
    {
        return $this->actionResourceFactory->fromModel($model);
    }
}
