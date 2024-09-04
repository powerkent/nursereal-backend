<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Doctrine\Repository;

use Nursery\Domain\Shared\Model\NurseryStructure;
use Nursery\Domain\Shared\Repository\NurseryStructureRepositoryInterface;

/**
 * @extends AbstractRepository<NurseryStructure>
 */
class NurseryStructureRepository extends AbstractRepository implements NurseryStructureRepositoryInterface
{
    protected static function entityClass(): string
    {
        return NurseryStructure::class;
    }
}
