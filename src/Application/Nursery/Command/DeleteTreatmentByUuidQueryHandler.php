<?php

declare(strict_types=1);

namespace Nursery\Application\Nursery\Command;

use Doctrine\ORM\EntityNotFoundException;
use Nursery\Domain\Nursery\Repository\TreatmentRepositoryInterface;
use Nursery\Domain\Shared\Command\CommandHandlerInterface;

final readonly class DeleteTreatmentByUuidQueryHandler implements CommandHandlerInterface
{
    public function __construct(
        private TreatmentRepositoryInterface $treatmentRepository,
    ) {
    }

    public function __invoke(DeleteTreatmentByUuidQuery $command): void
    {
        $treatment = $this->treatmentRepository->searchByUuid($command->uuid);

        if (null === $treatment) {
            throw new EntityNotFoundException(sprintf('unable to find the treatment you want to delete. uuid : %s', $command->uuid));
        }

        $this->treatmentRepository->delete($treatment);
    }
}
