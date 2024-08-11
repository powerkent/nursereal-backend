<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Doctrine\Repository;

use Nursery\Domain\Shared\Model\Action;
use Nursery\Domain\Shared\Repository\ActionRepositoryInterface;

/**
 * @extends AbstractRepository<Action>
 */
class ActionRepository extends AbstractRepository implements ActionRepositoryInterface
{
    protected static function entityClass(): string
    {
        return Action::class;
    }
}
