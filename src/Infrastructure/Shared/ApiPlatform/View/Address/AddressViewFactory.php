<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\View\Address;

use Nursery\Domain\Shared\Model\Address;

final readonly class AddressViewFactory
{
    public function fromModel(Address $address): AddressView
    {
        return new AddressView(
            id: $address->getId(),
            address: $address->getAddress(),
            zipcode: $address->getZipcode(),
            city: $address->getCity(),
        );
    }
}
