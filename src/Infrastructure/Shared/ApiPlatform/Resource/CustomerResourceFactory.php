<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Resource;

use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Shared\Model\Customer;
use Nursery\Infrastructure\Shared\ApiPlatform\View\ChildView;
use Nursery\Infrastructure\Shared\ApiPlatform\View\ChildViewFactory;

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
            email: $customer->getEmail(),
            phoneNumber: $customer->getPhoneNumber(),
            children: $customer->getChildren()->map(fn (Child $child): ChildView => $this->childViewFactory->fromModel($child))->toArray(),
        );
    }
}
