<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Query;

use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Shared\Query\QueryInterface;

final class FindContractDatesByChildQuery implements QueryInterface
{
    public function __construct(
        public Child $child,
    ) {
    }
}
