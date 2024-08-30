<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Exception;

use RuntimeException;
use Throwable;
use function sprintf;

final class MissingPropertyException extends RuntimeException
{
    /**
     * @param class-string $class
     */
    public function __construct(string $class, string $propertyName = 'id', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct(sprintf('%s with %s property is not set in requestBody.', $class, $propertyName), $code, $previous);
    }
}
