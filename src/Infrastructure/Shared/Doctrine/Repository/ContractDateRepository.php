<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Doctrine\Repository;

use Nursery\Domain\Shared\Model\ContractDate;
use Nursery\Domain\Shared\Repository\ContractDateRepositoryInterface;

/**
 * @extends AbstractRepository<ContractDate>
 */
class ContractDateRepository extends AbstractRepository implements ContractDateRepositoryInterface
{
    protected static function entityClass(): string
    {
        return ContractDate::class;
    }
}
