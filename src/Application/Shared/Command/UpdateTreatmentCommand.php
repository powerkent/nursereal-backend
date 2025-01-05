<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command;

use Nursery\Domain\Shared\Command\AbstractUpdateCommand;

final class UpdateTreatmentCommand extends AbstractUpdateCommand
{
    /**
     * @param array<string, mixed> $primitives
     */
    public static function create(array $primitives): UpdateTreatmentCommand
    {
        return new self($primitives);
    }
}
