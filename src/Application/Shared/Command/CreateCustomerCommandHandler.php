<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command;

use Nursery\Domain\Shared\Command\CommandHandlerInterface;
use Nursery\Domain\Shared\Model\Customer;
use Nursery\Infrastructure\Shared\Doctrine\Repository\CustomerRepository;

final readonly class CreateCustomerCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private CustomerRepository $customerRepository,
    ) {
    }

    public function __invoke(CreateCustomerCommand $command): Customer
    {
        $customer = new Customer(...$command->primitives);

        return $this->customerRepository->save($customer);
    }
}
