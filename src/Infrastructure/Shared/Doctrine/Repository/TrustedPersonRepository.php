<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Doctrine\Repository;

use Nursery\Domain\Shared\Model\TrustedPerson;
use Nursery\Domain\Shared\Repository\TrustedPersonRepositoryInterface;

/**
 * @extends AbstractRepository<TrustedPerson>
 */
class TrustedPersonRepository extends AbstractRepository implements TrustedPersonRepositoryInterface
{
    protected static function entityClass(): string
    {
        return TrustedPerson::class;
    }
}
