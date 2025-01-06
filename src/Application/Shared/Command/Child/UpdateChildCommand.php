<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command\Child;

use Nursery\Domain\Shared\Command\AbstractUpdateCommand;

final class UpdateChildCommand extends AbstractUpdateCommand
{
    /**
     * @param array<string, mixed> $primitives
     */
    public static function create(array $primitives): UpdateChildCommand
    {
        return new self($primitives);
    }
}
