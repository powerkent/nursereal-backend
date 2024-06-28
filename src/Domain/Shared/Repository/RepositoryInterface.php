<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Repository;

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
     * @phpstan-return list<T>
     */
    public function all(): array;

    public function exists(int $id): bool;

    /**
     * @phpstan-param T $entity
     */
    public function delete(object $entity): void;
}
