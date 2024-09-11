<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command;

use Nursery\Domain\Shared\Exception\EntityNotFoundException;
use Nursery\Domain\Shared\Model\Customer;
use Nursery\Domain\Shared\Repository\CustomerRepositoryInterface;
use Nursery\Domain\Shared\Command\CommandHandlerInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final readonly class DeleteCustomerByUuidCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private CustomerRepositoryInterface $customerRepository,
    ) {
    }

    public function __invoke(DeleteCustomerByUuidCommand $command): bool
    {
        $customer = $this->customerRepository->searchByUuid(is_string($command->uuid) ? Uuid::fromString($command->uuid) : $command->uuid);

        if (null === $customer) {
            throw new EntityNotFoundException(Customer::class, 'uuid', !$command->uuid instanceof UuidInterface ? $command->uuid : $command->uuid->toString());
        }

        $this->customerRepository->delete($customer);

        return true;
    }
}
