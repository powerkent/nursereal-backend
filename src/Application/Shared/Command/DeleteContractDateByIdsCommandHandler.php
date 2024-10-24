<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command;

use Nursery\Domain\Shared\Command\CommandHandlerInterface;
use Nursery\Domain\Shared\Repository\ChildRepositoryInterface;
use Nursery\Domain\Shared\Repository\ContractDateRepositoryInterface;

final readonly class DeleteContractDateByIdsCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private ChildRepositoryInterface $childRepository,
        private ContractDateRepositoryInterface $contractDateRepository,
    ) {
    }

    public function __invoke(DeleteContractDateByIdsCommand $command): bool
    {
        $child = $command->contract->getChild();
        if (null === $child) {
            return false;
        }

        $child->removeContractDate($command->contract);

        $this->childRepository->update($child);
        $this->contractDateRepository->delete($command->contract);

        return true;
    }
}
