<?php

declare(strict_types=1);

namespace Nursery\Application\Nursery\Query;

use Nursery\Domain\Shared\Query\QueryInterface;

final readonly class FindTreatmentByIdQuery implements QueryInterface
{
    public function __construct(public ?int $id)
    {
    }
}
