<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Processor\Agent;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use DateTimeImmutable;
use Exception;
use Nursery\Application\Shared\Command\Agent\CreateOrUpdateAgentScheduleCommand;
use Nursery\Application\Shared\Query\Agent\FindAgentByUuidOrIdQuery;
use Nursery\Domain\Shared\Command\CommandBusInterface;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Input\AgentScheduleInput;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\Agent\AgentScheduleResource;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\Agent\AgentScheduleResourceFactory;

/**
 * @implements ProcessorInterface<AgentScheduleInput, AgentScheduleResource>
 */
final readonly class AgentSchedulePutProcessor implements ProcessorInterface
{
    public function __construct(
        private QueryBusInterface $queryBus,
        private CommandBusInterface $commandBus,
        private AgentScheduleResourceFactory $agentScheduleResourceFactory,
    ) {
    }

    /**
     * @param  AgentScheduleInput $data
     * @throws Exception
     */
    public function process($data, Operation $operation, array $uriVariables = [], array $context = []): AgentScheduleResource
    {
        $primitives = [
            'uuid' => $uriVariables['uuid'],
            'agent' => $this->queryBus->ask(new FindAgentByUuidOrIdQuery(uuid: $data->agentUuid)),
            'arrivalDateTime' => null !== $data->arrivalDateTime ? new DateTimeImmutable($data->arrivalDateTime) : null,
            'endOfWorkDateTime' => null !== $data->endOfWorkDateTime ? new DateTimeImmutable($data->endOfWorkDateTime) : null,
            'breakDateTime' => null !== $data->breakDateTime ? new DateTimeImmutable($data->breakDateTime) : null,
            'endOfBreakDateTime' => null !== $data->endOfBreakDateTime ? new DateTimeImmutable($data->endOfBreakDateTime) : null,
        ];
        $agentSchedule = $this->commandBus->dispatch(CreateOrUpdateAgentScheduleCommand::create($primitives));

        return $this->agentScheduleResourceFactory->fromModel($agentSchedule);
    }
}
