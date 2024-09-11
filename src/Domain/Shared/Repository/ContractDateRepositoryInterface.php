<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Repository;

use DateTimeInterface;
use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Shared\Model\ContractDate;

/**
 * @extends RepositoryInterface<ContractDate>
 */
interface ContractDateRepositoryInterface extends RepositoryInterface
{
    /**
     * @return array<int, array<string, mixed>>
     */
    public function searchByDate(Child $child, DateTimeInterface $start): array;
}
