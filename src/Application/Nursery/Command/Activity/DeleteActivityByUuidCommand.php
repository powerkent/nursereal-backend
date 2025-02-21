<?php

declare(strict_types=1);

namespace Nursery\Application\Nursery\Command\Activity;

use Nursery\Domain\Shared\Command\CommandInterface;
use Ramsey\Uuid\UuidInterface;

final readonly class DeleteActivityByUuidCommand implements CommandInterface
{
    public function __construct(public UuidInterface|string $uuid)
    {
    }
}
