<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Nursery\Application\Shared\Command\CreateChildCommand;
use Nursery\Domain\Shared\Command\CommandBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Input\ChildPostInput;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\ChildResource;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\ChildResourceFactory;
use Ramsey\Uuid\Uuid;

final readonly class ChildPostProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private ChildResourceFactory $childResourceFactory,
    ) {
    }

    /**
     * @param ChildPostInput $data
     */
    public function process($data, Operation $operation, array $uriVariables = [], array $context = []): ChildResource
    {
        $primitives = [
            'uuid' => Uuid::uuid4(),
            'firstname' => $data->firstname,
            'lastname' => $data->lastname,
        ];

        $child = $this->commandBus->dispatch(CreateChildCommand::create($primitives));

        return $this->childResourceFactory->fromModel($child);
    }
}
