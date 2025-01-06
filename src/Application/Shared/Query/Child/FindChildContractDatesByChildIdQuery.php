<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Query\Child;

use Nursery\Domain\Shared\Query\QueryInterface;

final class FindChildContractDatesByChildIdQuery implements QueryInterface
{
    public function __construct(public int $childId)
    {
    }
}
