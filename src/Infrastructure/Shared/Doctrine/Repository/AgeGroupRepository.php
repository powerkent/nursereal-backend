<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Doctrine\Repository;

use Nursery\Domain\Shared\Model\AgeGroup;
use Nursery\Domain\Shared\Repository\AgeGroupRepositoryInterface;

/**
 * @extends AbstractRepository<AgeGroup>
 */
class AgeGroupRepository extends AbstractRepository implements AgeGroupRepositoryInterface
{
    protected static function entityClass(): string
    {
        return AgeGroup::class;
    }
}
