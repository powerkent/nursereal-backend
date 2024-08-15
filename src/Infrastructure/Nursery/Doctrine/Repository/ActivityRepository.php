<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\Doctrine\Repository;

use Nursery\Domain\Nursery\Model\Activity;
use Nursery\Domain\Nursery\Repository\ActivityRepositoryInterface;
use Nursery\Infrastructure\Shared\Doctrine\Repository\AbstractRepository;

/**
 * @extends AbstractRepository<Activity>
 */
class ActivityRepository extends AbstractRepository implements ActivityRepositoryInterface
{
    protected static function entityClass(): string
    {
        return Activity::class;
    }
}
