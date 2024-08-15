<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\View\Action;

use DateTimeInterface;
use Symfony\Component\Serializer\Annotation\Groups;

class TreatmentView
{
    public function __construct(
        #[Groups(['action:item'])]
        public string $name,
        #[Groups(['action:item'])]
        public ?string $description,
        #[Groups(['action:item'])]
        public DateTimeInterface $createdAt,
    ) {
    }
}
