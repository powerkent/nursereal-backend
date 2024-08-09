<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Doctrine\Repository;

use Nursery\Domain\Nursery\Model\Activity;
use Nursery\Domain\Shared\Repository\ActivityRepositoryInterface;

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
