<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Query\AgeGroup;

use Nursery\Domain\Shared\Query\QueryInterface;
use Ramsey\Uuid\UuidInterface;

final readonly class FindAgeGroupByUuidQuery implements QueryInterface
{
    public function __construct(public UuidInterface|string $uuid)
    {
    }
}
