<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Query\Customer;

use Nursery\Domain\Shared\Model\Customer;
use Nursery\Domain\Shared\Query\QueryHandlerInterface;
use Nursery\Domain\Shared\Repository\CustomerRepositoryInterface;

final readonly class FindCustomersQueryHandler implements QueryHandlerInterface
{
    public function __construct(private CustomerRepositoryInterface $customerRepository)
    {
    }

    /**
     * @return array<int, Customer>
     */
    public function __invoke(FindCustomersQuery $query): iterable
    {
        return $this->customerRepository->all();
    }
}
