<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Resource\Customer;

use Nursery\Domain\Shared\Model\Customer;
use Nursery\Infrastructure\Shared\ApiPlatform\View\Family\FamilyViewFactory;

final readonly class CustomerResourceFactory
{
    public function __construct(private FamilyViewFactory $familyViewFactory)
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
            family: null !== $customer->getFamily() ? $this->familyViewFactory->fromModel($customer->getFamily()) : null,
        );
    }
}
