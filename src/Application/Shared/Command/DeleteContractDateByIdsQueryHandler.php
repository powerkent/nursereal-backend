<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command;

use Nursery\Domain\Shared\Command\CommandHandlerInterface;
use Nursery\Domain\Shared\Repository\ChildRepositoryInterface;
use Nursery\Domain\Shared\Repository\ContractDateRepositoryInterface;

final readonly class DeleteContractDateByIdsQueryHandler implements CommandHandlerInterface
{
    public function __construct(
        private ChildRepositoryInterface $childRepository,
        private ContractDateRepositoryInterface $contractDateRepository,
    ) {
    }

    public function __invoke(DeleteContractDateByIdsQuery $command): bool
    {
        $child = $command->contract->getChild();

        $child->removeContractDate($command->contract);

        $this->childRepository->update($child);
        $this->contractDateRepository->delete($command->contract);

        return true;
    }
}
