<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\Doctrine\Repository;

use Nursery\Domain\Nursery\Model\IRP;
use Nursery\Domain\Nursery\Repository\IRPRepositoryInterface;
use Nursery\Infrastructure\Shared\Doctrine\Repository\AbstractRepository;

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
