<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Query\ClockingIn;

use Nursery\Domain\Shared\Query\QueryInterface;
use Ramsey\Uuid\UuidInterface;

final readonly class FindClockingInByUuidQuery implements QueryInterface
{
    public function __construct(public UuidInterface|string $uuid)
    {
    }
}
