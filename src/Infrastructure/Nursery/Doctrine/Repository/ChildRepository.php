<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\Doctrine\Repository;

use Nursery\Domain\Nursery\Model\Child;
use Nursery\Domain\Nursery\Repository\ChildRepositoryInterface;
use Nursery\Infrastructure\Shared\Doctrine\Repository\AbstractRepository;

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
