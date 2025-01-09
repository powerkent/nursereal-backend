<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command\Agent;

use Nursery\Domain\Shared\Command\CommandHandlerInterface;
use Nursery\Domain\Shared\Exception\EntityNotFoundException;
use Nursery\Domain\Shared\Model\ShiftType;
use Nursery\Domain\Shared\Repository\ShiftTypeRepositoryInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final readonly class DeleteShiftTypeByUuidCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private ShiftTypeRepositoryInterface $shiftTypeRepository,
    ) {
    }

    public function __invoke(DeleteShiftTypeByUuidCommand $command): bool
    {
        $shiftType = $this->shiftTypeRepository->searchByUuid(is_string($command->uuid) ? Uuid::fromString($command->uuid) : $command->uuid);

        if (null === $shiftType) {
            throw new EntityNotFoundException(ShiftType::class, 'uuid', !$command->uuid instanceof UuidInterface ? $command->uuid : $command->uuid->toString());
        }

        $this->shiftTypeRepository->delete($shiftType);

        return true;
    }
}
