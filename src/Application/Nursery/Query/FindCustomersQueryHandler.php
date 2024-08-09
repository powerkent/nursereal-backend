<?php

declare(strict_types=1);

namespace Nursery\Application\Nursery\Query;

use Nursery\Domain\Nursery\Model\Customer;
use Nursery\Domain\Nursery\Repository\CustomerRepositoryInterface;
use Nursery\Domain\Shared\Query\QueryHandlerInterface;

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
