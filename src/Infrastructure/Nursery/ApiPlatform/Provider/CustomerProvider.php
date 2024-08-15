<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\Provider;

use ApiPlatform\Metadata\Operation;
use Nursery\Application\Nursery\Query\FindCustomerByUuidQuery;
use Nursery\Domain\Nursery\Model\Customer;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Nursery\ApiPlatform\Resource\CustomerResource;
use Nursery\Infrastructure\Nursery\ApiPlatform\Resource\CustomerResourceFactory;
use Nursery\Infrastructure\Shared\ApiPlatform\Provider\AbstractProvider;

/**
 * @extends AbstractProvider<Customer, CustomerResource>
 */
final class CustomerProvider extends AbstractProvider
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
