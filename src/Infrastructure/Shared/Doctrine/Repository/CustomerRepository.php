<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Doctrine\Repository;

use Nursery\Domain\Shared\Model\Customer;
use Nursery\Domain\Shared\Repository\RepositoryInterface;

class CustomerRepository extends AbstractRepository implements RepositoryInterface
{
    protected static function entityClass(): string
    {
        return Customer::class;
    }
}
