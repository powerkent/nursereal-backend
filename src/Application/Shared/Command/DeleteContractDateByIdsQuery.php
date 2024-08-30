<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command;

use Nursery\Domain\Shared\Command\CommandInterface;
use Nursery\Domain\Shared\Model\ContractDate;

final readonly class DeleteContractDateByIdsQuery implements CommandInterface
{
    public function __construct(public ContractDate $contract)
    {
    }
}
