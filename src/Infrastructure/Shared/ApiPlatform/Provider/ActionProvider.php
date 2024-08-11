<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use Nursery\Application\Shared\Query\FindActionByUuidQuery;
use Nursery\Domain\Shared\Model\Action;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Nursery\ApiPlatform\Resource\CustomerResourceFactory;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\ActionResource;

/**
 * @extends AbstractProvider<Action, ActionResource>
 */
final class ActionProvider extends AbstractProvider implements ProviderInterface
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
        private readonly CustomerResourceFactory $customerResourceFactory,
    ) {
    }

    protected function item(Operation $operation, array $uriVariables = [], array $context = []): ?Action
    {
        return $this->queryBus->ask(new FindActionByUuidQuery(uuid: $uriVariables['uuid']));
    }

    /**
     * @param Action $model
     *
     * @return ActionResource
     */
    protected function toResource(object $model): object
    {
        return $this->customerResourceFactory->fromModel($model);
    }
}
