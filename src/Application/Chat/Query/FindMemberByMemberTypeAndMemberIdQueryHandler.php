<?php

declare(strict_types=1);

namespace Nursery\Application\Chat\Query;

use Nursery\Domain\Chat\Model\Member;
use Nursery\Domain\Chat\Repository\MemberRepositoryInterface;
use Nursery\Domain\Shared\Query\QueryHandlerInterface;

final readonly class FindMemberByMemberTypeAndMemberIdQueryHandler implements QueryHandlerInterface
{
    public function __construct(private MemberRepositoryInterface $memberRepository)
    {
    }

    final public function __invoke(FindMemberByMemberTypeAndMemberIdQuery $query): ?Member
    {
        return $this->memberRepository->searchByTypeAndMemberId(
            type: $query->type,
            memberId: $query->memberId
        );
    }
}
