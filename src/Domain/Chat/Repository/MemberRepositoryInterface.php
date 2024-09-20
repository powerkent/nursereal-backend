<?php

declare(strict_types=1);

namespace Nursery\Domain\Chat\Repository;

use Nursery\Domain\Chat\Enum\MemberType;
use Nursery\Domain\Chat\Model\Member;
use Nursery\Domain\Shared\Repository\RepositoryInterface;

/**
 * @extends RepositoryInterface<Member>
 */
interface MemberRepositoryInterface extends RepositoryInterface
{
    public function searchByTypeAndMemberId(MemberType $type, int $memberId): ?Member;
}
