<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Input;

use Symfony\Component\Serializer\Annotation\Groups;

final class ConfigInput
{
    public function __construct(
        #[Groups(['config:item'])]
        public string $name,
        #[Groups(['config:item'])]
        public bool $value,
    ) {
    }
}
