<?php

declare(strict_types=1);

namespace Nursery\Application\Chat\Query;

use Nursery\Domain\Chat\Enum\MemberType;
use Nursery\Domain\Shared\Query\QueryInterface;

final readonly class FindMemberByMemberTypeAndMemberIdQuery implements QueryInterface
{
    public function __construct(
        public MemberType $type,
        public int $memberId,
    ) {
    }
}
