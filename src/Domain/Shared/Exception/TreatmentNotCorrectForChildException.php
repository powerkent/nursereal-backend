<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Exception;

use RuntimeException;
use Throwable;
use function sprintf;

final class TreatmentNotCorrectForChildException extends RuntimeException
{
    public function __construct(mixed $id, string $idProperty = 'uuid', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct(sprintf('Current treatment #%s: %s is not the right treatment for the child', $idProperty, $id), $code, $previous);
    }
}
