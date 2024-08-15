<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Doctrine\Repository;

use Nursery\Domain\Shared\Model\Dosage;
use Nursery\Domain\Shared\Repository\DosageRepositoryInterface;

/**
 * @extends AbstractRepository<Dosage>
 */
class DosageRepository extends AbstractRepository implements DosageRepositoryInterface
{
    protected static function entityClass(): string
    {
        return Dosage::class;
    }
}
