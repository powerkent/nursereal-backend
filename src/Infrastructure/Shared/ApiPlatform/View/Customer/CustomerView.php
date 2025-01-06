<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\View\Customer;

use DateTimeInterface;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;

class CustomerView
{
    public function __construct(
        #[Groups(['child:item', 'child:list', 'customer:item'])]
        public UuidInterface $uuid,
        #[Groups(['child:item', 'child:list', 'customer:item'])]
        public string $firstname,
        #[Groups(['child:item', 'child:list', 'customer:item'])]
        public string $lastname,
        #[Groups(['child:item', 'child:list', 'customer:item'])]
        public ?string $email,
        #[Groups(['child:item', 'child:list', 'customer:item'])]
        public string $phoneNumber,
        #[Groups(['child:item', 'child:list', 'customer:item'])]
        public DateTimeInterface $createdAt,
    ) {
    }
}
