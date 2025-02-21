<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command\Child;

use Nursery\Domain\Shared\Command\AbstractCreateCommand;

final class CreateChildCommand extends AbstractCreateCommand
{
    public static function create(array $primitives): CreateChildCommand
    {
        return new self($primitives);
    }
}
