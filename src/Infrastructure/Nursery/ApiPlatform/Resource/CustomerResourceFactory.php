<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\Resource;

use Nursery\Domain\Nursery\Model\Child;
use Nursery\Domain\Nursery\Model\Customer;
use Nursery\Infrastructure\Nursery\ApiPlatform\View\ChildView;
use Nursery\Infrastructure\Nursery\ApiPlatform\View\ChildViewFactory;

final class CustomerResourceFactory
{
    public function __construct(private ChildViewFactory $childViewFactory)
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
            children: $customer->getChildren()?->map(fn (Child $child): ChildView => $this->childViewFactory->fromModel($child))->toArray(),
        );
    }
}
