<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use DateTimeImmutable;
use Nursery\Application\Shared\Query\FindChildByUuidOrIdQuery;
use Nursery\Application\Nursery\Command\CreateActionCommand;
use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Shared\Command\CommandBusInterface;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Nursery\ApiPlatform\Input\ActionInput;
use Nursery\Infrastructure\Nursery\ApiPlatform\Resource\Action\ActionResource;
use Nursery\Infrastructure\Nursery\ApiPlatform\Resource\Action\ActionResourceFactory;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\InputBag;

/**
 * @implements ProcessorInterface<ActionInput, ActionResource>
 */
final class ActionProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private QueryBusInterface $queryBus,
        private ActionResourceFactory $actionResourceFactory,
    ) {
    }

    /**
     * @param ActionInput $data
     */
    public function process($data, Operation $operation, array $uriVariables = [], array $context = []): ActionResource
    {
        /** @var InputBag $query */
        /* @phpstan-ignore-next-line */
        $query = $context['request']->query;

        $primitives = [
            'uuid' => Uuid::uuid4(),
            'createdAt' => new DateTimeImmutable(),
            'updatedAt' => null,
            'children' => array_map(fn (array $child): Child => $this->queryBus->ask(new FindChildByUuidOrIdQuery($child['uuid'])), $data->children),
            'comment' => $data->comment,
            'query' => $query,
            'attributes' => [
                'activity' => $data->activity?->uuid,
                'rest' => ['restEndTime' => $data->restEndTime],
                'treatment' => [
                    'uuid' => $data->treatment?->treatmentUuid,
                    'dose' => $data->treatment?->dose,
                    'dosingTime' => $data->treatment?->dosingTime,
                    'temperature' => $data->treatment?->temperature,
                ],
            ],
        ];

        $action = $this->commandBus->dispatch(CreateActionCommand::create($primitives));

        return $this->actionResourceFactory->fromModel($action);
    }
}
