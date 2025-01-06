<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command\ClockingIn;

use Nursery\Domain\Shared\Command\AbstractCreateCommand;

final class CreateOrUpdateClockingInCommand extends AbstractCreateCommand
{
    public static function create(array $primitives): CreateOrUpdateClockingInCommand
    {
        return new self($primitives);
    }
}
