<?php

declare(strict_types=1);

namespace Nursery\Application\Nursery\Command;

use Nursery\Domain\Shared\Command\AbstractUpdateCommand;

final class UpdateChildCommand extends AbstractUpdateCommand
{
    public static function create(array $primitives): static
    {
        return new self($primitives);
    }
}
