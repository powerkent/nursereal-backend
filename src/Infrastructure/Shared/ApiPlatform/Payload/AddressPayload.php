<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Payload;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

final class AddressPayload
{
    public function __construct(
        #[Groups(['family:item', 'nurseryStructure:item'])]
        #[Assert\NotBlank(message: 'Address requires this field.')]
        public string $address,
        #[Groups(['family:item', 'nurseryStructure:item'])]
        #[Assert\NotBlank(message: 'Address requires a zipcode.')]
        public int $zipcode,
        #[Groups(['family:item', 'nurseryStructure:item'])]
        #[Assert\NotBlank(message: 'Address requires a city.')]
        public string $city,
        #[Groups(['family:item', 'nurseryStructure:item'])]
        public ?int $id = null,
    ) {
    }
}
