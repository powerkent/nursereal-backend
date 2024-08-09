<?php

declare(strict_types=1);

namespace Nursery\Application\Nursery\Command;

use Nursery\Domain\Nursery\Model\Customer;
use Nursery\Domain\Nursery\Repository\CustomerRepositoryInterface;
use Nursery\Domain\Shared\Command\CommandHandlerInterface;

final readonly class CreateCustomerCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private CustomerRepositoryInterface $customerRepository,
    ) {
    }

    public function __invoke(CreateCustomerCommand $command): Customer
    {
        $customer = new Customer(...$command->primitives);

        return $this->customerRepository->save($customer);
    }
}
