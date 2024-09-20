<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Chat\ApiPlatform\View;

use Nursery\Domain\Chat\Model\Member;
use Nursery\Domain\Chat\Service\MemberService;

final readonly class MemberViewFactory
{
    public function __construct(
        private MemberService $memberService
    ) {
    }

    public function fromModel(Member $authorMember): MemberView
    {
        $author = $this->memberService->getMember($authorMember->getType(), $authorMember->getMemberId());

        return new MemberView(
            memberId: $authorMember->getMemberId(),
            firstname: $author?->getFirstname(),
            lastname: $author?->getLastname(),
        );
    }
}
