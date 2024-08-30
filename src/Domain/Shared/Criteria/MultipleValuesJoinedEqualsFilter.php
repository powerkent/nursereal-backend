<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Criteria;

class MultipleValuesJoinedEqualsFilter extends AbstractRestrictingFilter
{
    /**
     * @param list<mixed>  $values
     * @param class-string $joinTargetEntityClass
     */
    public function __construct(
        string $field,
        array $values,
        public readonly string $joinRootField,
        public readonly string $joinTargetEntityClass,
        public readonly string $joinTargetField,
    ) {
        parent::__construct($field, $values);
    }
}
