<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command\Family;

use Nursery\Domain\Shared\Command\CommandInterface;
use Ramsey\Uuid\UuidInterface;

final readonly class DeleteFamilyByUuidCommand implements CommandInterface
{
    public function __construct(public UuidInterface|string $uuid)
    {
    }
}
