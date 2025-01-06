<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command\Dosage;

use Nursery\Domain\Shared\Command\AbstractCreateCommand;

final class CreateDosageCommand extends AbstractCreateCommand
{
    public static function create(array $primitives): CreateDosageCommand
    {
        return new self($primitives);
    }
}
