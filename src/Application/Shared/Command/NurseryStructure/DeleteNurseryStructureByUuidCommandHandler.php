<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command\NurseryStructure;

use Nursery\Domain\Shared\Command\CommandHandlerInterface;
use Nursery\Domain\Shared\Exception\EntityNotFoundException;
use Nursery\Domain\Shared\Model\NurseryStructure;
use Nursery\Domain\Shared\Repository\NurseryStructureRepositoryInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final readonly class DeleteNurseryStructureByUuidCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private NurseryStructureRepositoryInterface $nurseryStructureRepository,
    ) {
    }

    public function __invoke(DeleteNurseryStructureByUuidCommand $command): bool
    {
        $nurseryStructure = $this->nurseryStructureRepository->searchByUuid(is_string($command->uuid) ? Uuid::fromString($command->uuid) : $command->uuid);

        if (null === $nurseryStructure) {
            throw new EntityNotFoundException(NurseryStructure::class, 'uuid', !$command->uuid instanceof UuidInterface ? $command->uuid : $command->uuid->toString());
        }

        $this->nurseryStructureRepository->delete($nurseryStructure);

        return true;
    }
}
