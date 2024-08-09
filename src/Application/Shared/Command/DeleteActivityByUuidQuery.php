<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Command;

use Ramsey\Uuid\UuidInterface;

final readonly class DeleteActivityByUuidQuery implements CommandInterface
{
    public function __construct(public UuidInterface|string $uuid)
    {
    }
}
