<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Doctrine\ORM;

use Closure;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Exception;
use Traversable;
use function is_callable;

/**
 * @template T of object
 *
 * @extends Paginator<T>
 */
final class CastingPaginator extends Paginator
{
    /**
     * @param Paginator<object> $paginator
     */
    public function __construct(
        Paginator $paginator,
        private readonly Closure $castCallable,
    ) {
        parent::__construct($paginator->getQuery(), $paginator->getFetchJoinCollection());
    }

    /**
     * @psalm-return Traversable<array-key, T>
     * @throws Exception
     */
    public function getIterator(): Traversable
    {
        $it = parent::getIterator();
        if (is_callable($this->castCallable)) {
            foreach ($it as &$el) {
                $el = ($this->castCallable)($el);
            }
        }

        return $it;
    }
}
