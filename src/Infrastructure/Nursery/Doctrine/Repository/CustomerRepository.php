<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\Doctrine\Repository;

use Nursery\Domain\Nursery\Model\Customer;
use Nursery\Domain\Nursery\Repository\CustomerRepositoryInterface;
use Nursery\Infrastructure\Shared\Doctrine\Repository\AbstractRepository;

/**
 * @extends AbstractRepository<Customer>
 */
class CustomerRepository extends AbstractRepository implements CustomerRepositoryInterface
{
    protected static function entityClass(): string
    {
        return Customer::class;
    }
}
