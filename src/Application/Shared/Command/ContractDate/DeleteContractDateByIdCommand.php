<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command\ContractDate;

use Nursery\Domain\Shared\Command\CommandInterface;

final readonly class DeleteContractDateByIdCommand implements CommandInterface
{
    public function __construct(public int $id)
    {
    }
}
