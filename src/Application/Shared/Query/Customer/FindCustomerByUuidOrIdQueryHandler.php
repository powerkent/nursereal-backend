<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Query\Customer;

use Nursery\Domain\Shared\Model\Customer;
use Nursery\Domain\Shared\Query\QueryHandlerInterface;
use Nursery\Domain\Shared\Repository\CustomerRepositoryInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final readonly class FindCustomerByUuidOrIdQueryHandler implements QueryHandlerInterface
{
    public function __construct(private CustomerRepositoryInterface $customerRepository)
    {
    }

    final public function __invoke(FindCustomerByUuidOrIdQuery $query): ?Customer
    {
        if (null !== $query->id) {
            return $this->customerRepository->search($query->id);
        }

        if (null === $query->uuid) {
            return null;
        }

        return $this->customerRepository->searchByUuid(
            $query->uuid instanceof UuidInterface
                ? $query->uuid
                : Uuid::fromString($query->uuid)
        );
    }
}
