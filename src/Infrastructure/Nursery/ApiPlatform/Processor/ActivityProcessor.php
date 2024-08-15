<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Nursery\Application\Nursery\Command\CreateOrUpdateActivityCommand;
use Nursery\Domain\Shared\Command\CommandBusInterface;
use Nursery\Infrastructure\Nursery\ApiPlatform\Input\ActivityInput;
use Nursery\Infrastructure\Nursery\ApiPlatform\Resource\ActivityResource;
use Nursery\Infrastructure\Nursery\ApiPlatform\Resource\ActivityResourceFactory;
use Ramsey\Uuid\Uuid;

/**
 * @implements ProcessorInterface<ActivityInput, ActivityResource>
 */
final class ActivityProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private ActivityResourceFactory $activityResourceFactory,
    ) {
    }

    /**
     * @param ActivityInput $data
     */
    public function process($data, Operation $operation, array $uriVariables = [], array $context = []): ActivityResource
    {
        $primitives = [
            'uuid' => $uriVariables['uuid'] ?? Uuid::uuid4(),
            'name' => $data->name,
            'description' => $data->description,
        ];

        $activity = $this->commandBus->dispatch(CreateOrUpdateActivityCommand::create($primitives));

        return $this->activityResourceFactory->fromModel($activity);
    }
}
