<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Input;

use Nursery\Domain\Shared\Enum\ActionType;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

final class ActionInput
{
    public function __construct(
        #[Groups(['activity:item'])]
        #[Assert\NotBlank(message: 'Action requires an action type.')]
        public ActionType $type,
    ) {
    }
}
