<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command\Family;

use Nursery\Domain\Shared\Command\CommandHandlerInterface;
use Nursery\Domain\Shared\Exception\EntityNotFoundException;
use Nursery\Domain\Shared\Model\Family;
use Nursery\Domain\Shared\Repository\FamilyRepositoryInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final readonly class DeleteFamilyByUuidCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private FamilyRepositoryInterface $familyRepository,
    ) {
    }

    public function __invoke(DeleteFamilyByUuidCommand $command): bool
    {
        $family = $this->familyRepository->searchByUuid(is_string($command->uuid) ? Uuid::fromString($command->uuid) : $command->uuid);

        if (null === $family) {
            throw new EntityNotFoundException(Family::class, 'uuid', !$command->uuid instanceof UuidInterface ? $command->uuid : $command->uuid->toString());
        }

        $this->familyRepository->delete($family);

        return true;
    }
}
