<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\Provider;

use ApiPlatform\Metadata\Operation;
use Nursery\Application\Nursery\Query\FindActionByUuidQuery;
use Nursery\Domain\Nursery\Model\Action;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Provider\AbstractProvider;
use Nursery\Infrastructure\Nursery\ApiPlatform\Resource\Action\ActionResource;
use Nursery\Infrastructure\Nursery\ApiPlatform\Resource\Action\ActionResourceFactory;

/**
 * @extends AbstractProvider<Action, ActionResource>
 */
final class ActionProvider extends AbstractProvider
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
        private readonly ActionResourceFactory $actionResourceFactory,
    ) {
    }

    protected function item(Operation $operation, array $uriVariables = [], array $context = []): ?Action
    {
        dump($action = $this->queryBus->ask(new FindActionByUuidQuery(uuid: $uriVariables['uuid'])));

        return $action;
    }

    /**
     * @param Action $model
     *
     * @return ActionResource
     */
    protected function toResource(object $model): object
    {
        return $this->actionResourceFactory->fromModel($model);
    }
}
