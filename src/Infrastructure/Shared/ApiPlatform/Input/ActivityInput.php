<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Input;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

final class ActivityInput
{
    public function __construct(
        #[Groups(['activity:item'])]
        #[Assert\NotBlank(message: 'Activity requires a name.')]
        public string $name,
        #[Groups(['activity:item'])]
        public ?string $description = null,
    ) {
    }
}
