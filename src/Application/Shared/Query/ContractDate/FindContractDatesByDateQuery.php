<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Query\ContractDate;

use DateTimeInterface;
use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Shared\Query\QueryInterface;

final class FindContractDatesByDateQuery implements QueryInterface
{
    public function __construct(
        public DateTimeInterface $start,
        public ?Child $child = null,
    ) {
    }
}
