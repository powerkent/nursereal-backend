<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Doctrine\Repository;

use Nursery\Domain\Shared\Criteria\Criteria;
use Nursery\Domain\Shared\Criteria\EqualsFilter;
use Nursery\Domain\Shared\Criteria\MultipleValuesEqualsFilter;
use Nursery\Domain\Shared\Criteria\MultipleValuesJoinedEqualsFilter;
use Nursery\Domain\Shared\Criteria\PaginationFilter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;
use Ramsey\Uuid\UuidInterface;
use function sprintf;

/**
 * @template T of object
 *
 * @extends ServiceEntityRepository<T>
 */
abstract class AbstractRepository extends ServiceEntityRepository
{
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly ManagerRegistry $registry,
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
     * @param array<string, mixed> $filters
     *
     * @phpstan-return list<T>
     */
    public function searchByFilters(array $filters): ?array
    {
        return $this->findBy($filters);
    }

    /**
     * @param array<string, mixed> $filter
     *
     * @phpstan-return T|null
     */
    public function searchOneByFilter(array $filter): ?object
    {
        return $this->findOneBy($filter);
    }

    /**
     * @phpstan-return iterable<T>
     */
    public function searchByCriteria(Criteria $criteria): iterable
    {
        [$qb, $paginated] = $this->createQueryFromCriteria($criteria);

        return $paginated ? new Paginator($qb->getQuery()) : $qb->getQuery()->getResult();
    }

    /**
     * @return array{0: QueryBuilder, 1: bool}
     */
    protected function createQueryFromCriteria(Criteria $criteria): array
    {
        $qb = $this->createQueryBuilder('o');

        $paginated = false;

        foreach ($criteria->filters as $i => $filter) {
            if ($filter instanceof EqualsFilter) {
                $qb
                    ->andWhere($qb->expr()->eq(sprintf('o.%s', $filter->field), sprintf(':value_%d', $i)))
                    ->setParameter(sprintf(':value_%d', $i), $filter->value)
                ;

                continue;
            }

            if ($filter instanceof MultipleValuesEqualsFilter) {
                $qb
                    ->andWhere($qb->expr()->in(sprintf('o.%s', $filter->field), sprintf(':value_%d', $i)))
                    ->setParameter(sprintf(':value_%d', $i), $filter->value)
                ;

                continue;
            }

            if ($filter instanceof MultipleValuesJoinedEqualsFilter) {
                $qb
                    ->join(
                        $filter->joinTargetEntityClass,
                        sprintf('j_%d', $i),
                        Join::WITH,
                        sprintf('o.%s = j_%d.%s', $filter->joinRootField, $i, $filter->joinTargetField)
                    )
                    ->andWhere($qb->expr()->in(sprintf('j_%d.%s', $i, $filter->field), sprintf(':value_%d', $i)))
                    ->setParameter(sprintf(':value_%d', $i), $filter->value)
                ;
                continue;
            }

            if ($filter instanceof PaginationFilter) {
                $paginated = true;

                $qb
                    ->setFirstResult($filter->page * $filter->itemsPerPage)
                    ->setMaxResults($filter->itemsPerPage)
                ;
            }
        }

        return [$qb, $paginated];
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
