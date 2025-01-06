<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command\Customer;

use Nursery\Domain\Shared\Command\CommandHandlerInterface;
use Nursery\Domain\Shared\Model\Customer;
use Nursery\Domain\Shared\Repository\CustomerRepositoryInterface;

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
