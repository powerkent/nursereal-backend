<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\Resource;

use Model\Child;
use Model\Customer;

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
            phoneNumber: $customer->getPhoneNumber(),
            children: $customer->getChildren()->map(fn (Child $child): ChildResource => $this->childResourceFactory->fromModel($child))->toArray(),
        );
    }
}
