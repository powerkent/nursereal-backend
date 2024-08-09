<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\Doctrine\Repository;

use Nursery\Domain\Nursery\Model\Treatment;
use Nursery\Domain\Nursery\Repository\TreatmentRepositoryInterface;
use Nursery\Infrastructure\Shared\Doctrine\Repository\AbstractRepository;

/**
 * @extends AbstractRepository<Treatment>
 */
class TreatmentRepository extends AbstractRepository implements TreatmentRepositoryInterface
{
    protected static function entityClass(): string
    {
        return Treatment::class;
    }
}
