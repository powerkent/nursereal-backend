<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Exception;

use RuntimeException;
use Throwable;

final class OnlyOneClockingInPerDayException extends RuntimeException
{
    public function __construct(int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct('Invalid request. There can only be one clocking-in per day and per agent', $code, $previous);
    }
}
