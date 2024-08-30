<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Criteria;

abstract class AbstractRestrictingFilter implements FilterInterface
{
    public function __construct(
        public readonly string $field,
        public readonly mixed $value,
    ) {
    }
}
