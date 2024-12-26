<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Repository;

use Nursery\Domain\Shared\Criteria\Criteria;
use Ramsey\Uuid\UuidInterface;

/**
 * @template T of object
 */
interface RepositoryInterface
{
    /**
     * @phpstan-return T|null
     */
    public function searchByUuid(UuidInterface $uuid): ?object;

    /**
     * @phpstan-param array<string, mixed> $filters
     *
     * @phpstan-return list<T>|null
     */
    public function searchByFilters(array $filters): ?array;

    /**
     * @phpstan-return iterable<T>
     */
    public function searchByCriteria(Criteria $criteria): iterable;

    /**
     * @phpstan-param T $entity
     *
     * @phpstan-return T
     */
    public function save(object $entity): object;

    /**
     * @phpstan-param T $entity
     *
     * @phpstan-return T
     */
    public function update(object $entity): object;

    /**
     * @phpstan-return T|null
     */
    public function search(int $id): ?object;

    /**
     * @phpstan-param array<string, mixed> $filter
     *
     * @phpstan-return T|null
     */
    public function searchOneByFilter(array $filter): ?object;

    /**
     * @phpstan-return list<T>
     */
    public function all(): array;

    public function exists(int $id): bool;

    /**
     * @phpstan-param T $entity
     */
    public function delete(object $entity): void;
}
