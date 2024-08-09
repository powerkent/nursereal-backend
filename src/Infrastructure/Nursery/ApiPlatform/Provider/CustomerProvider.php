<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\Resource\CustomerResource;
use ApiPlatform\Resource\CustomerResourceFactory;
use ApiPlatform\State\ProviderInterface;
use Model\Customer;
use Nursery\ApiPlatform\Provider\AbstractProvider;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Query\FindCustomerByUuidQuery;

final class CustomerProvider extends AbstractProvider implements ProviderInterface
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
        private readonly CustomerResourceFactory $customerResourceFactory,
    ) {
    }

    protected function item(Operation $operation, array $uriVariables = [], array $context = []): ?Customer
    {
        return $this->queryBus->ask(new FindCustomerByUuidQuery(uuid: $uriVariables['uuid']));
    }

    /**
     * @param Customer $model
     *
     * @return CustomerResource
     */
    protected function toResource(object $model): object
    {
        return $this->customerResourceFactory->fromModel($model);
    }
}
