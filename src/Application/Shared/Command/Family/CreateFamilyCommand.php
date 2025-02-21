<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command\Family;

use Nursery\Domain\Shared\Command\AbstractCreateCommand;

final class CreateFamilyCommand extends AbstractCreateCommand
{
    public static function create(array $primitives): CreateFamilyCommand
    {
        return new self($primitives);
    }
}
