<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Nursery\Application\Shared\Command\CreateCustomerCommand;
use Nursery\Application\Shared\Query\FindChildByUuidQuery;
use Nursery\Domain\Shared\Command\CommandBusInterface;
use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Input\CustomerPostInput;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\CustomerResource;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\CustomerResourceFactory;
use Ramsey\Uuid\Uuid;

final readonly class CustomerPostProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private QueryBusInterface $queryBus,
        private CustomerResourceFactory $customerResourceFactory,
    ) {
    }

    /**
     * @param CustomerPostInput $data
     */
    public function process($data, Operation $operation, array $uriVariables = [], array $context = []): CustomerResource
    {
        $primitives = [
            'uuid' => Uuid::uuid4(),
            'firstname' => $data->firstname,
            'lastname' => $data->lastname,
            'email' => $data->email,
            'children' => array_map(fn (array $child): Child => $this->queryBus->ask(new FindChildByUuidQuery($child['uuid'])), $data->children),
        ];

        $customer = $this->commandBus->dispatch(CreateCustomerCommand::create($primitives));

        return $this->customerResourceFactory->fromModel($customer);
    }
}
