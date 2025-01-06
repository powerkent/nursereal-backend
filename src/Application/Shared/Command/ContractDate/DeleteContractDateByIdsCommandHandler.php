<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command\ContractDate;

use Nursery\Domain\Shared\Command\CommandHandlerInterface;
use Nursery\Domain\Shared\Repository\ContractDateRepositoryInterface;

final readonly class DeleteContractDateByIdsCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private ContractDateRepositoryInterface $contractDateRepository,
    ) {
    }

    public function __invoke(DeleteContractDateByIdsCommand $command): bool
    {
        foreach ($command->ids as $id) {
            $contractDate = $this->contractDateRepository->search($id);

            if (null === $contractDate) {
                continue;
            }

            $this->contractDateRepository->delete($contractDate);
        }

        return true;
    }
}
