<?php

declare(strict_types=1);

namespace Nursery\Application\Nursery\Command;

use Nursery\Domain\Shared\Command\AbstractCreateCommand;

final class CreateOrUpdateActivityCommand extends AbstractCreateCommand
{
    public static function create(array $primitives): CreateOrUpdateActivityCommand
    {
        return new self($primitives);
    }
}
