<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Doctrine\Repository;

use Nursery\Domain\Shared\Model\Avatar;
use Nursery\Domain\Shared\Repository\AvatarRepositoryInterface;

/**
 * @extends AbstractRepository<Avatar>
 */
class AvatarRepository extends AbstractRepository implements AvatarRepositoryInterface
{
    protected static function entityClass(): string
    {
        return Avatar::class;
    }
}
