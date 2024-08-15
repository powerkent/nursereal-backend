<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Doctrine\Repository;

use Nursery\Domain\Shared\Model\Treatment;
use Nursery\Domain\Shared\Repository\TreatmentRepositoryInterface;

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
