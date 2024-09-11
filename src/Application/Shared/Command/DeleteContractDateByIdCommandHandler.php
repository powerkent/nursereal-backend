<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command;

use Nursery\Domain\Shared\Exception\EntityNotFoundException;
use Nursery\Domain\Shared\Model\ContractDate;
use Nursery\Domain\Shared\Command\CommandHandlerInterface;
use Nursery\Domain\Shared\Repository\ContractDateRepositoryInterface;

final readonly class DeleteContractDateByIdCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private ContractDateRepositoryInterface $contractDateRepository,
    ) {
    }

    public function __invoke(DeleteContractDateByIdCommand $command): bool
    {
        $contractDate = $this->contractDateRepository->search($command->id);

        if (null === $contractDate) {
            throw new EntityNotFoundException(ContractDate::class, $command->id, 'id');
        }

        $this->contractDateRepository->delete($contractDate);

        return true;
    }
}
