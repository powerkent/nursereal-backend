<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Exception;

use RuntimeException;
use Throwable;

final class OnlyOneChildPerContractCalendarException extends RuntimeException
{
    public function __construct(int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct('Invalid request. The parameter \'child\' must be provided only once on POST child_calendar_entries', $code, $previous);
    }
}
