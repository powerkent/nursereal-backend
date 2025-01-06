<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command\Agent;

use Nursery\Domain\Shared\Command\AbstractCreateCommand;

final class CreateOrUpdateAgentCommand extends AbstractCreateCommand
{
    public static function create(array $primitives): CreateOrUpdateAgentCommand
    {
        return new self($primitives);
    }
}
