<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use DateTimeImmutable;
use Nursery\Application\Nursery\Command\CreateCustomerCommand;
use Nursery\Application\Nursery\Query\FindChildByUuidQuery;
use Nursery\Domain\Nursery\Model\Child;
use Nursery\Domain\Shared\Command\CommandBusInterface;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Nursery\ApiPlatform\Input\CustomerPostInput;
use Nursery\Infrastructure\Nursery\ApiPlatform\Resource\CustomerResource;
use Nursery\Infrastructure\Nursery\ApiPlatform\Resource\CustomerResourceFactory;
use Ramsey\Uuid\Uuid;

/**
 * @implements ProcessorInterface<CustomerResource>
 */
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
            'email' => $data?->email,
            'phoneNumber' => $data->phoneNumber,
            'children' => array_map(fn (array $child): Child => $this->queryBus->ask(new FindChildByUuidQuery($child['uuid'])), $data->children),
            'createdAt' => new DateTimeImmutable(),
        ];

        $customer = $this->commandBus->dispatch(CreateCustomerCommand::create($primitives));

        return $this->customerResourceFactory->fromModel($customer);
    }
}
