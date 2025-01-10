<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command\Agent;

use Nursery\Application\Shared\Query\Agent\FindAgentScheduleByUuidQuery;
use Nursery\Domain\Shared\Command\CommandHandlerInterface;
use Nursery\Domain\Shared\Model\AgentSchedule;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Domain\Shared\Repository\AgentScheduleRepositoryInterface;
use Nursery\Domain\Shared\Serializer\NormalizerInterface;

final readonly class CreateOrUpdateAgentScheduleCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private QueryBusInterface $queryBus,
        private AgentScheduleRepositoryInterface $agentScheduleRepository,
        private NormalizerInterface $normalizer,
    ) {
    }

    public function __invoke(CreateOrUpdateAgentScheduleCommand $command): AgentSchedule
    {
        /** @var ?AgentSchedule $agentSchedule */
        $agentSchedule = $this->queryBus->ask(new FindAgentScheduleByUuidQuery($command->primitives['uuid']));

        if (null !== $agentSchedule) {
            $agentSchedule = $this->normalizer->denormalize($command->primitives, AgentSchedule::class, context: ['object_to_populate' => $agentSchedule]);

            return $this->agentScheduleRepository->update($agentSchedule);
        }

        $agentSchedule = new AgentSchedule(...$command->primitives);

        return $this->agentScheduleRepository->save($agentSchedule);
    }
}
