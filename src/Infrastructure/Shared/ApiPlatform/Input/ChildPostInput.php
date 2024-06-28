<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Input;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

final class ChildPostInput
{
    public function __construct(
        #[Groups(['child:item'])]
        #[Assert\NotBlank(message: 'Child requires a firstname.')]
        public string $firstname,
        #[Groups(['child:item'])]
        #[Assert\NotBlank(message: 'Child requires a lastname.')]
        public string $lastname,
    ) {
    }
}
