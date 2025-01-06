<?php

declare(strict_types=1);

namespace Customer;

use ApiPlatform\Metadata\Operation;
use Exception;
<<<<<<< Updated upstream:src/Infrastructure/Shared/ApiPlatform/Provider/CustomerProvider.php
use Nursery\Application\Shared\Query\FindCustomerByUuidOrIdQuery;
=======
use Nursery\Application\Shared\Query\Customer\FindCustomerByUuidOrIdQuery;
>>>>>>> Stashed changes:src/Infrastructure/Shared/ApiPlatform/Provider/Customer/CustomerProvider.php
use Nursery\Domain\Shared\Model\Customer;
use Nursery\Domain\Shared\Query\QueryBusInterface;
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
