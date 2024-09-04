<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use DateTimeImmutable;
use Nursery\Application\Shared\Command\CreateAgentCommand;
use Nursery\Application\Shared\Query\FindNurseryStructureByUuidQuery;
use Nursery\Domain\Shared\Command\CommandBusInterface;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Input\AgentInput;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\AgentResource;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\AgentResourceFactory;
use Ramsey\Uuid\Uuid;

/**
 * @implements ProcessorInterface<AgentInput, AgentResource>
 */
final readonly class AgentProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private QueryBusInterface $queryBus,
        private AgentResourceFactory $agentResourceFactory,
    ) {
    }

    /**
     * @param AgentInput $data
     */
    public function process($data, Operation $operation, array $uriVariables = [], array $context = []): AgentResource
    {
        $primitives = [
            'uuid' => Uuid::uuid4(),
            'firstname' => $data->firstname,
            'lastname' => $data->lastname,
            'email' => $data->email,
            'password' => $data->password,
            'nurseryStructure' => null !== $data->nurseryStructurePayload ? $this->queryBus->ask(new FindNurseryStructureByUuidQuery($data->nurseryStructurePayload->uuid)) : null,
            'createdAt' => new DateTimeImmutable(),
        ];

        $agent = $this->commandBus->dispatch(CreateAgentCommand::create($primitives));

        return $this->agentResourceFactory->fromModel($agent);
    }
}
