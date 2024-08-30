<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Exception;

use RuntimeException;
use Throwable;
use function sprintf;

final class EntityNotFoundException extends RuntimeException
{
    /**
     * @param class-string $class
     */
    public function __construct(string $class, mixed $id, string $propertyName = 'id', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct(sprintf('%s with %s "%s" not found.', $class, $propertyName, $id), $code, $previous);
    }
}
