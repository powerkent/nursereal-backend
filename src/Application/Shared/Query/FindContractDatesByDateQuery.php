<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Query;

use DateTimeInterface;
use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Shared\Query\QueryInterface;

final class FindContractDatesByDateQuery implements QueryInterface
{
    public function __construct(
        public Child $child,
        public DateTimeInterface $start
    ) {
    }
}
