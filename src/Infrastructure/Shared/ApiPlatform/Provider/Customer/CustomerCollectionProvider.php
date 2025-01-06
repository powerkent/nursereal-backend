<?php

declare(strict_types=1);

namespace Customer;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\Pagination;
use Nursery\Application\Shared\Query\Customer\FindCustomersQuery;
use Nursery\Domain\Shared\Model\Customer;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Provider\AbstractCollectionProvider;

/**
 * @extends AbstractCollectionProvider<Customer, CustomerResource>
 */
final class CustomerCollectionProvider extends AbstractCollectionProvider
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
        private readonly CustomerResourceFactory $customerResourceFactory,
        Pagination $pagination,
    ) {
        parent::__construct($pagination);
    }

    /**
     * @param array<string, mixed> $uriVariables
     */
    public function collection(Operation $operation, array $uriVariables = [], array $filters = [], array $context = []): iterable
    {
        return $this->queryBus->ask(new FindCustomersQuery());
    }

    protected function toResource($model): object
    {
        return $this->customerResourceFactory->fromModel($model);
    }
}
