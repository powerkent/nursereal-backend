<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Exception;

use RuntimeException;
use Throwable;

final class ContractDateShouldHaveSameDayDateException extends RuntimeException
{
    public function __construct(int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct('Unable to have a contract date over several days for contract.', $code, $previous);
    }
}
