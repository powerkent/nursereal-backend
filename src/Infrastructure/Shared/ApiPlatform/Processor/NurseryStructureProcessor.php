<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Nursery\Application\Shared\Command\CreateOrUpdateNurseryStructureCommand;
use Nursery\Domain\Shared\Command\CommandBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\OpenApi\NurseryStructureOpenApiContext;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\NurseryStructureResource;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\NurseryStructureResourceFactory;
use Ramsey\Uuid\Uuid;
use function dump;

/**
 * @implements ProcessorInterface<NurseryStructureOpenApiContext, NurseryStructureResource>
 */
final readonly class NurseryStructureProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private NurseryStructureResourceFactory $nurseryStructureResourceFactory,
    ) {
    }

    public function process($data, Operation $operation, array $uriVariables = [], array $context = []): NurseryStructureResource
    {
        $primitives = [
            'uuid' => $uriVariables['uuid'] ?? Uuid::uuid4(),
            'name' => $data->name,
            'address' => $data->address,
            'openingHour' => $data->openingHour,
            'closingHour' => $data->closingHour,
            'openingDays' => $data->openingDays,
        ];

        $activity = $this->commandBus->dispatch(CreateOrUpdateNurseryStructureCommand::create($primitives));

        return $this->nurseryStructureResourceFactory->fromModel($activity);
    }
}
