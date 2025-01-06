<?php

declare(strict_types=1);

namespace Customer;

use Child\ChildView;
use Child\ChildViewFactory;
use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Shared\Model\Customer;

final readonly class CustomerResourceFactory
{
    public function __construct(private ChildViewFactory $childViewFactory)
    {
    }

    public function fromModel(Customer $customer): CustomerResource
    {
        return new CustomerResource(
            uuid: $customer->getUuid(),
            avatar: $customer->getAvatar()?->getContentUrl(),
            firstname: $customer->getFirstname(),
            lastname: $customer->getLastname(),
            user: $customer->getUser(),
            email: $customer->getEmail(),
            phoneNumber: $customer->getPhoneNumber(),
            children: $customer->getChildren()->map(fn (Child $child): ChildView => $this->childViewFactory->fromModel($child))->toArray(),
        );
    }
}
