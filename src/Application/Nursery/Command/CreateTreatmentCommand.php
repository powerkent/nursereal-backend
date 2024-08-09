<?php

declare(strict_types=1);

namespace Nursery\Application\Nursery\Command;

use Nursery\Domain\Shared\Command\AbstractCreateCommand;

final class CreateTreatmentCommand extends AbstractCreateCommand
{
    public static function create(array $primitives): static
    {
        return new self($primitives);
    }
}
