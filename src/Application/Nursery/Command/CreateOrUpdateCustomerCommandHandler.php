<?php

declare(strict_types=1);

namespace Nursery\Application\Nursery\Command;

use DateTimeImmutable;
use Nursery\Domain\Nursery\Model\Customer;
use Nursery\Domain\Nursery\Repository\CustomerRepositoryInterface;
use Nursery\Domain\Shared\Command\CommandHandlerInterface;
use Nursery\Domain\Shared\Serializer\NormalizerInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final readonly class CreateOrUpdateCustomerCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private CustomerRepositoryInterface $customerRepository,
        private NormalizerInterface $normalizer,
    ) {
    }

    public function __invoke(CreateOrUpdateCustomerCommand $command): Customer
    {
        /** @var ?Customer $customer */
        $customer = $this->customerRepository->searchByUuid(!$command->primitives['uuid'] instanceof UuidInterface ? Uuid::fromString($command->primitives['uuid']) : $command->primitives['uuid']);

        if (null !== $customer) {
            $children = $command->primitives['children'];
            unset($command->primitives['children']);
            $customer = $this->normalizer->denormalize($command->primitives, Customer::class, context: ['object_to_populate' => $customer]);

            $customer->setChildren($children);

            return $this->customerRepository->update($customer);
        }

        $command->primitives['createdAt'] = new DateTimeImmutable();

        return $this->customerRepository->save(new Customer(...$command->primitives));
    }
}
