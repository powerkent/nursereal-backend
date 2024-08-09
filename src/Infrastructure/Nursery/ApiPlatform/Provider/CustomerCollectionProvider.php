<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\Resource\CustomerResource;
use ApiPlatform\Resource\CustomerResourceFactory;
use ApiPlatform\State\Pagination\Pagination;
use Model\Child;
use Model\Customer;
use Nursery\ApiPlatform\Provider\AbstractCollectionProvider;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Query\FindCustomersQuery;

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
     * @param Child                $filters
     * @param array<string, mixed> $context
     *
     * @return Child
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
