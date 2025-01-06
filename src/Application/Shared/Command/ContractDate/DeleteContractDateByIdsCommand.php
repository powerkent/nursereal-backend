<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command\ContractDate;

use Nursery\Domain\Shared\Command\CommandInterface;

final readonly class DeleteContractDateByIdsCommand implements CommandInterface
{
    /**
     * @param array<int, int> $ids
     */
    public function __construct(public array $ids)
    {
    }
}
