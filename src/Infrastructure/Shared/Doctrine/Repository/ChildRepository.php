<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Doctrine\Repository;

use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Shared\Repository\ChildRepositoryInterface;

/**
 * @extends AbstractRepository<Child>
 */
class ChildRepository extends AbstractRepository implements ChildRepositoryInterface
{
    protected static function entityClass(): string
    {
        return Child::class;
    }
}
