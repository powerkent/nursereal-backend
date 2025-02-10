<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Query\Family;

use Nursery\Domain\Shared\Query\QueryInterface;
use Ramsey\Uuid\UuidInterface;

final readonly class FindFamilyByUuidQuery implements QueryInterface
{
    public function __construct(public UuidInterface|string $uuid)
    {
    }
}
