<?php

declare(strict_types=1);

namespace Nursery\Application\Nursery\Command;

use Doctrine\ORM\EntityNotFoundException;
use Nursery\Domain\Nursery\Repository\CustomerRepositoryInterface;
use Nursery\Domain\Shared\Command\CommandHandlerInterface;
use Ramsey\Uuid\Uuid;

final readonly class DeleteCustomerByUuidQueryHandler implements CommandHandlerInterface
{
    public function __construct(
        private CustomerRepositoryInterface $customerRepository,
    ) {
    }

    public function __invoke(DeleteCustomerByUuidQuery $command): bool
    {
        $customer = $this->customerRepository->searchByUuid(is_string($command->uuid) ? Uuid::fromString($command->uuid) : $command->uuid);

        if (null === $customer) {
            throw new EntityNotFoundException(sprintf('unable to find the customer you want to delete. uuid : %s', $command->uuid));
        }

        $this->customerRepository->delete($customer);

        return true;
    }
}
