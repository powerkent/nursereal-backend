<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command\NurseryStructure;

use Nursery\Domain\Shared\Command\AbstractCreateCommand;

final class CreateOrUpdateNurseryStructureCommand extends AbstractCreateCommand
{
    public static function create(array $primitives): CreateOrUpdateNurseryStructureCommand
    {
        return new self($primitives);
    }
}
