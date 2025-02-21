<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command\Avatar;

use Nursery\Domain\Shared\Command\AbstractCreateCommand;

final class CreateAvatarCommand extends AbstractCreateCommand
{
    public static function create(array $primitives): CreateAvatarCommand
    {
        return new self($primitives);
    }
}
