<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Doctrine\Repository;

use Nursery\Domain\Shared\Model\NurseryStructureOpening;
use Nursery\Domain\Shared\Repository\NurseryStructureOpeningRepositoryInterface;

/**
 * @extends AbstractRepository<NurseryStructureOpening>
 */
class NurseryStructureOpeningRepository extends AbstractRepository implements NurseryStructureOpeningRepositoryInterface
{
    protected static function entityClass(): string
    {
        return NurseryStructureOpening::class;
    }
}
