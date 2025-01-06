<?php

declare(strict_types=1);

namespace Nursery\Application\Chat\Command\Channel;

use Nursery\Domain\Shared\Command\AbstractCreateCommand;

final class CreateChannelCommand extends AbstractCreateCommand
{
    public static function create(array $primitives): CreateChannelCommand
    {
        return new self($primitives);
    }
}
