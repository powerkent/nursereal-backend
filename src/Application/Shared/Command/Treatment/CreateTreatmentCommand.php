<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command\Treatment;

use Nursery\Domain\Shared\Command\AbstractCreateCommand;

final class CreateTreatmentCommand extends AbstractCreateCommand
{
    public static function create(array $primitives): CreateTreatmentCommand
    {
        return new self($primitives);
    }
}
