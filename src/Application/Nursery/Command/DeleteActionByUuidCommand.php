<?php

declare(strict_types=1);

namespace Nursery\Application\Nursery\Command;

use Nursery\Domain\Shared\Command\CommandInterface;
use Ramsey\Uuid\UuidInterface;

final readonly class DeleteActionByUuidCommand implements CommandInterface
{
    public function __construct(public UuidInterface|string $uuid)
    {
    }
}
