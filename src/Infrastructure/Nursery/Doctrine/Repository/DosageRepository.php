<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\Doctrine\Repository;

use Nursery\Domain\Nursery\Model\Dosage;
use Nursery\Domain\Nursery\Repository\DosageRepositoryInterface;
use Nursery\Infrastructure\Shared\Doctrine\Repository\AbstractRepository;

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
