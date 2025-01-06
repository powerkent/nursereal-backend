<?php

declare(strict_types=1);

namespace Customer;

use Nursery\Domain\Shared\Model\Customer;

final readonly class CustomerViewFactory
{
    public function fromModel(Customer $customer): CustomerView
    {
        return new CustomerView(
            uuid: $customer->getUuid(),
            firstname: $customer->getFirstname(),
            lastname: $customer->getLastname(),
            email: $customer->getEmail(),
            phoneNumber: $customer->getPhoneNumber(),
            createdAt: $customer->getCreatedAt(),
        );
    }
}
