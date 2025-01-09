<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Query\Agent;

use Nursery\Domain\Shared\Query\QueryInterface;
use Ramsey\Uuid\UuidInterface;

final readonly class FindShiftTypeByUuidQuery implements QueryInterface
{
    public function __construct(public UuidInterface|string $uuid)
    {
    }
}
