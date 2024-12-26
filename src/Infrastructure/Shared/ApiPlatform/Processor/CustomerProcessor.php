<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Nursery\Application\Shared\Command\CreateOrUpdateCustomerCommand;
use Nursery\Application\Shared\Query\FindChildByUuidOrIdQuery;
use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Shared\Command\CommandBusInterface;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Input\CustomerInput;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\CustomerResource;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\CustomerResourceFactory;
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
            'user' => $data->user,
            'password' => $data->password,
            'phoneNumber' => $data->phoneNumber,
            'children' => array_map(fn (array $child): Child => $this->queryBus->ask(new FindChildByUuidOrIdQuery($child['uuid'])), $data->children),
        ];

        $customer = $this->commandBus->dispatch(CreateOrUpdateCustomerCommand::create($primitives));

        return $this->customerResourceFactory->fromModel($customer);
    }
}
