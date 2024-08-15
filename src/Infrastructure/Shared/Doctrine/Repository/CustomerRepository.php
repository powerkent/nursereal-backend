<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Doctrine\Repository;

use Nursery\Domain\Shared\Model\Customer;
use Nursery\Domain\Shared\Repository\CustomerRepositoryInterface;

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
