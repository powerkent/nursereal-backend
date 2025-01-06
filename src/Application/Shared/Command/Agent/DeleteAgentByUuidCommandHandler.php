<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command\Agent;

use Nursery\Domain\Shared\Command\CommandHandlerInterface;
use Nursery\Domain\Shared\Exception\EntityNotFoundException;
use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Shared\Repository\AgentRepositoryInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final readonly class DeleteAgentByUuidCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private AgentRepositoryInterface $agentRepository,
    ) {
    }

    public function __invoke(DeleteAgentByUuidCommand $command): bool
    {
        $agent = $this->agentRepository->searchByUuid(is_string($command->uuid) ? Uuid::fromString($command->uuid) : $command->uuid);

        if (null === $agent) {
            throw new EntityNotFoundException(Child::class, 'uuid', !$command->uuid instanceof UuidInterface ? $command->uuid : $command->uuid->toString());
        }

        $this->agentRepository->delete($agent);

        return true;
    }
}
