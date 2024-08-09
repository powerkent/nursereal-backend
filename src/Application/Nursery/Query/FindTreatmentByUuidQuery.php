<?php

declare(strict_types=1);

namespace Nursery\Application\Nursery\Query;

use Nursery\Domain\Shared\Query\QueryInterface;
use Ramsey\Uuid\UuidInterface;

final readonly class FindTreatmentByUuidQuery implements QueryInterface
{
    public function __construct(public UuidInterface|string $uuid)
    {
    }
}
