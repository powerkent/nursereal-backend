<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Provider\Customer;

use ApiPlatform\Metadata\Operation;
use Exception;
use Nursery\Application\Shared\Query\Customer\FindCustomerByUuidOrIdQuery;
use Nursery\Domain\Shared\Model\Customer;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Provider\AbstractProvider;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\Customer\CustomerResource;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\Customer\CustomerResourceFactory;

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

    /**
     * @throws Exception
     */
    protected function item(Operation $operation, array $uriVariables = [], array $context = []): ?Customer
    {
        return $this->queryBus->ask(new FindCustomerByUuidOrIdQuery(uuid: $uriVariables['uuid']));
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
