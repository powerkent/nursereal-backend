<?php

declare(strict_types=1);

namespace Nursery\Application\Nursery\Query;

use Nursery\Domain\Nursery\Model\Customer;
use Nursery\Domain\Nursery\Repository\CustomerRepositoryInterface;
use Nursery\Domain\Shared\Query\QueryHandlerInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final readonly class FindCustomerByUuidQueryHandler implements QueryHandlerInterface
{
    public function __construct(private CustomerRepositoryInterface $customerRepository)
    {
    }

    final public function __invoke(FindCustomerByUuidQuery $query): ?Customer
    {
        return $this->customerRepository->searchByUuid(!$query->uuid instanceof UuidInterface ? Uuid::fromString($query->uuid) : $query->uuid);
    }
}
