<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command\Treatment;

use Nursery\Domain\Shared\Command\CommandHandlerInterface;
use Nursery\Domain\Shared\Exception\EntityNotFoundException;
use Nursery\Domain\Shared\Model\Treatment;
use Nursery\Domain\Shared\Repository\TreatmentRepositoryInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use function is_string;

final readonly class DeleteTreatmentByUuidCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private TreatmentRepositoryInterface $treatmentRepository,
    ) {
    }

    public function __invoke(DeleteTreatmentByUuidCommand $command): bool
    {
        $treatment = $this->treatmentRepository->searchByUuid(is_string($command->uuid) ? Uuid::fromString($command->uuid) : $command->uuid);

        if (null === $treatment) {
            throw new EntityNotFoundException(Treatment::class, 'uuid', !$command->uuid instanceof UuidInterface ? $command->uuid : $command->uuid->toString());
        }

        $this->treatmentRepository->delete($treatment);

        return true;
    }
}
