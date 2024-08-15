<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\View;

use Nursery\Domain\Nursery\Model\Customer;

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
