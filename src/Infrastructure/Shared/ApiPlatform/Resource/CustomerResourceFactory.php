<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Resource;

use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Shared\Model\Customer;

final class CustomerResourceFactory
{
    public function __construct(private ChildResourceFactory $childResourceFactory)
    {
    }

    public function fromModel(Customer $customer): CustomerResource
    {
        return new CustomerResource(
            uuid: $customer->getUuid(),
            firstname: $customer->getFirstname(),
            lastname: $customer->getLastname(),
            email: $customer->getEmail(),
            children: $customer->getChildren()->map(fn (Child $child): ChildResource => $this->childResourceFactory->fromModel($child))->toArray(),
        );
    }
}
