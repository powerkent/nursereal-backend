<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Query;

use Ramsey\Uuid\UuidInterface;

final readonly class FindActionByUuidQuery implements QueryInterface
{
    public function __construct(public UuidInterface|string $uuid)
    {
    }
}
