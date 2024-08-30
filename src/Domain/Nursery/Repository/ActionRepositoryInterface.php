<?php

declare(strict_types=1);

namespace Nursery\Domain\Nursery\Repository;

use Nursery\Domain\Nursery\Model\Action;
use Nursery\Domain\Shared\Repository\RepositoryInterface;

/**
 * @extends RepositoryInterface<Action>
 */
interface ActionRepositoryInterface extends RepositoryInterface
{
    /**
     * @param list<int>    $children
     * @param list<string> $actionTypes
     *
     * @return array<Action>|null
     */
    public function searchByFilter(array $children = [], array $actionTypes = []): ?array;
}
