<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command\Agent;

use Nursery\Domain\Shared\Command\CommandHandlerInterface;
use Nursery\Domain\Shared\Model\AgentSchedule;
use Nursery\Domain\Shared\Repository\AgentScheduleRepositoryInterface;

final readonly class CreateAgentScheduleCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private AgentScheduleRepositoryInterface $agentScheduleRepository,
    ) {
    }

    public function __invoke(CreateAgentScheduleCommand $command): AgentSchedule
    {
        $agentSchedule = new AgentSchedule(...$command->primitives);

        return $this->agentScheduleRepository->save($agentSchedule);
    }
}
