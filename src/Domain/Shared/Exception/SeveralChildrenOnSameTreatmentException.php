<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Exception;

use RuntimeException;
use Throwable;
use function sprintf;

final class SeveralChildrenOnSameTreatmentException extends RuntimeException
{
    public function __construct(mixed $id, string $idProperty = 'id', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct(sprintf('Unable to have several children on the same treatment %s: %s', $idProperty, $id), $code, $previous);
    }
}
