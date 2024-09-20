<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Chat\Doctrine\Repository;

use Nursery\Domain\Chat\Enum\MemberType;
use Nursery\Domain\Chat\Model\Member;
use Nursery\Domain\Chat\Repository\MemberRepositoryInterface;
use Nursery\Infrastructure\Shared\Doctrine\Repository\AbstractRepository;

/**
 * @extends AbstractRepository<Member>
 */
class MemberRepository extends AbstractRepository implements MemberRepositoryInterface
{
    protected static function entityClass(): string
    {
        return Member::class;
    }

    public function searchByTypeAndMemberId(MemberType $type, int $memberId): ?Member
    {
        return $this->findOneBy(['type' => $type, 'memberId' => $memberId]);
    }
}
