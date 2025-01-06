<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command\Config;

use Nursery\Domain\Shared\Command\AbstractCreateCommand;

final class UpdateConfigCommand extends AbstractCreateCommand
{
    public static function create(array $primitives): UpdateConfigCommand
    {
        return new self($primitives);
    }
}
