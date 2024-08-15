<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Nursery\Application\Nursery\Command\CreateOrUpdateCustomerCommand;
use Nursery\Application\Nursery\Query\FindChildByUuidQuery;
use Nursery\Domain\Nursery\Model\Child;
use Nursery\Domain\Shared\Command\CommandBusInterface;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Nursery\ApiPlatform\Input\CustomerInput;
use Nursery\Infrastructure\Nursery\ApiPlatform\Resource\CustomerResource;
use Nursery\Infrastructure\Nursery\ApiPlatform\Resource\CustomerResourceFactory;
use Ramsey\Uuid\Uuid;

/**
 * @implements ProcessorInterface<CustomerInput, CustomerResource>
 */
final readonly class CustomerProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private QueryBusInterface $queryBus,
        private CustomerResourceFactory $customerResourceFactory,
    ) {
    }

    /**
     * @param CustomerInput $data
     */
    public function process($data, Operation $operation, array $uriVariables = [], array $context = []): CustomerResource
    {
        $primitives = [
            'uuid' => $uriVariables['uuid'] ?? Uuid::uuid4(),
            'firstname' => $data->firstname,
            'lastname' => $data->lastname,
            'email' => $data->email,
            'phoneNumber' => $data->phoneNumber,
            'children' => array_map(fn (array $child): Child => $this->queryBus->ask(new FindChildByUuidQuery($child['uuid'])), $data->children),
        ];

        $customer = $this->commandBus->dispatch(CreateOrUpdateCustomerCommand::create($primitives));

        return $this->customerResourceFactory->fromModel($customer);
    }
}
