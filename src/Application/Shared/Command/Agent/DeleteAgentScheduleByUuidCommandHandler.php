<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command\Agent;

use Nursery\Domain\Shared\Command\CommandHandlerInterface;
use Nursery\Domain\Shared\Exception\EntityNotFoundException;
use Nursery\Domain\Shared\Model\AgentSchedule;
use Nursery\Domain\Shared\Repository\AgentScheduleRepositoryInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final readonly class DeleteAgentScheduleByUuidCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private AgentScheduleRepositoryInterface $agentScheduleRepository,
    ) {
    }

    public function __invoke(DeleteAgentScheduleByUuidCommand $command): bool
    {
        $agentSchedule = $this->agentScheduleRepository->searchByUuid(is_string($command->uuid) ? Uuid::fromString($command->uuid) : $command->uuid);

        if (null === $agentSchedule) {
            throw new EntityNotFoundException(AgentSchedule::class, 'uuid', !$command->uuid instanceof UuidInterface ? $command->uuid : $command->uuid->toString());
        }

        $this->agentScheduleRepository->delete($agentSchedule);

        return true;
    }
}
