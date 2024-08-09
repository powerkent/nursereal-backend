<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Doctrine\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Nursery\Domain\Shared\Repository\RepositoryInterface;
use Ramsey\Uuid\UuidInterface;

/**
 * @template T of object
 *
 * @extends ServiceEntityRepository<T>
 */
abstract class AbstractRepository extends ServiceEntityRepository implements RepositoryInterface
{
    public function __construct(
        private ManagerRegistry $registry,
    ) {
        parent::__construct($registry, static::entityClass());
    }

    /**
     * @phpstan-return class-string<T>
     */
    abstract protected static function entityClass(): string;

    /**
     * @phpstan-return T|null
     */
    public function searchByUuid(UuidInterface $uuid): ?object
    {
        return $this->findOneBy(['uuid' => $uuid]);
    }

    /**
     * @phpstan-param T $entity
     *
     * @phpstan-return T
     */
    public function save(object $entity): object
    {
        try {
            $this->getEntityManager()->persist($entity);
            $this->getEntityManager()->flush();
        } catch (ORMException $exception) {
            $this->logger->critical(
                '{exception}: {class}, previous exception: {previous}',
                [
                    'exception' => $exception->getMessage(),
                    'class' => get_class($entity),
                    'previous' => $exception->getPrevious()?->getMessage(),
                    'stacktrace' => $exception->getTraceAsString(),
                ]
            );
        }

        if (!$this->getEntityManager()->isOpen()) {
            $this->registry->resetManager();
        }

        return $entity;
    }

    /**
     * @phpstan-param T $entity
     *
     * @phpstan-return T
     */
    public function update(object $entity): object
    {
        $this->getEntityManager()->flush();

        return $entity;
    }

    /**
     * @phpstan-return T|null
     */
    public function search(int $id): ?object
    {
        return $this->find($id);
    }

    /**
     * @phpstan-return list<T>
     */
    public function all(): array
    {
        return $this->findAll();
    }

    public function exists(int $id): bool
    {
        return 0 < $this->count(['id' => $id]);
    }

    /**
     * @phpstan-param T $entity
     */
    public function delete(object $entity): void
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }
}
