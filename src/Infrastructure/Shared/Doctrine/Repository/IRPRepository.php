<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Doctrine\Repository;

use Nursery\Domain\Shared\Model\IRP;
use Nursery\Domain\Shared\Repository\IRPRepositoryInterface;

/**
 * @extends AbstractRepository<IRP>
 */
class IRPRepository extends AbstractRepository implements IRPRepositoryInterface
{
    protected static function entityClass(): string
    {
        return IRP::class;
    }
}
