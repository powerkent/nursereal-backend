<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command;

use Nursery\Domain\Shared\Command\AbstractCreateCommand;

final class CreateActionCommand extends AbstractCreateCommand
{
    public static function create(array $primitives): static
    {
        return new self($primitives);
    }
}
