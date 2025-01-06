<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Config\ConfigResource;
use Config\ConfigResourceFactory;
use Nursery\Application\Shared\Command\Config\UpdateConfigCommand;
use Nursery\Domain\Shared\Command\CommandBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Input\ConfigInput;
use Ramsey\Uuid\Uuid;

/**
 * @implements ProcessorInterface<ConfigInput, ConfigResource>
 */
final readonly class ConfigProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private ConfigResourceFactory $configResourceFactory,
    ) {
    }

    /**
     * @param ConfigInput $data
     */
    public function process($data, Operation $operation, array $uriVariables = [], array $context = []): ConfigResource
    {
        $primitives = [
            'uuid' => $uriVariables['uuid'] ?? Uuid::uuid4(),
            'name' => $data->name,
            'value' => $data->value,
        ];

        $customer = $this->commandBus->dispatch(UpdateConfigCommand::create($primitives));

        return $this->configResourceFactory->fromModel($customer);
    }
}
