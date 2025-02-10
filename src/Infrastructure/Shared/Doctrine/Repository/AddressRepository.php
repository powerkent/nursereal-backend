<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Doctrine\Repository;

use Nursery\Domain\Shared\Model\Address;
use Nursery\Domain\Shared\Repository\AddressRepositoryInterface;

/**
 * @extends AbstractRepository<Address>
 */
class AddressRepository extends AbstractRepository implements AddressRepositoryInterface
{
    protected static function entityClass(): string
    {
        return Address::class;
    }
}
