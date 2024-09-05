<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use DateTimeImmutable;
use Nursery\Application\Shared\Command\CreateNurseryStructureCommand;
use Nursery\Domain\Shared\Command\CommandBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Input\NurseryStructureInput;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\NurseryStructureResource;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\NurseryStructureResourceFactory;
use Ramsey\Uuid\Uuid;

/**
 * @implements ProcessorInterface<NurseryStructureInput, NurseryStructureResource>
 */
final class NurseryStructureProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private NurseryStructureResourceFactory $nurseryStructureResourceFactory,
    ) {
    }

    /**
     * @param NurseryStructureInput $data
     */
    public function process($data, Operation $operation, array $uriVariables = [], array $context = []): NurseryStructureResource
    {
        $primitives = [
            'uuid' => Uuid::uuid4(),
            'name' => $data->name,
            'address' => $data->address,
            'createdAt' => new DateTimeImmutable(),
            'startAt' => $data->startAt,
        ];

        $activity = $this->commandBus->dispatch(CreateNurseryStructureCommand::create($primitives));

        return $this->nurseryStructureResourceFactory->fromModel($activity);
    }
}
