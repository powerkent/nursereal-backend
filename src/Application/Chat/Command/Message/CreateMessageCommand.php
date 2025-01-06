<?php

declare(strict_types=1);

namespace Nursery\Application\Chat\Command\Message;

use Nursery\Domain\Shared\Command\AbstractCreateCommand;

final class CreateMessageCommand extends AbstractCreateCommand
{
    public static function create(array $primitives): CreateMessageCommand
    {
        return new self($primitives);
    }
}
