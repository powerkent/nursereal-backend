<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Exception;
use InvalidArgumentException;
use Nursery\Application\Shared\Command\ClockingIn\CreateOrUpdateClockingInCommand;
use Nursery\Application\Shared\Query\Agent\FindAgentByUuidOrIdQuery;
use Nursery\Domain\Shared\Command\CommandBusInterface;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Input\ClockingInInput;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\ClockingIn\ClockingInResource;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\ClockingIn\ClockingInResourceFactory;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\HttpFoundation\Request;

/**
 * @implements ProcessorInterface<ClockingInInput, ClockingInResource>
 */
final readonly class ClockingInProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private QueryBusInterface $queryBus,
        private ClockingInResourceFactory $clockingInResourceFactory,
    ) {
    }

    /**
     * @param  ClockingInInput $data
     * @throws Exception
     */
    public function process($data, Operation $operation, array $uriVariables = [], array $context = []): ClockingInResource
    {
        /** @var Request|null $request */
        $request = $context['request'] ?? null;

        if (!$request instanceof Request) {
            throw new InvalidArgumentException('Invalid request type in context.');
        }

        /** @var InputBag<string> $query */
        $query = $request->query;

        $agent = $this->queryBus->ask(new FindAgentByUuidOrIdQuery(uuid: $data->agentUuid));

        $primitives = [
            'uuid' => $uriVariables['uuid'] ?? Uuid::uuid4(),
            'startDateTime' => $data->startDateTime,
            'endDateTime' => $data->endDateTime,
            'agent' => $agent,
            'nurseryStructureUuid' => $query->get('nursery_structure_uuid'),
        ];

        $clockingIn = $this->commandBus->dispatch(CreateOrUpdateClockingInCommand::create($primitives));

        return $this->clockingInResourceFactory->fromModel($clockingIn);
    }
}
