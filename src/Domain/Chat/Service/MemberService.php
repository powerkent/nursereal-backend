<?php

declare(strict_types=1);

namespace Nursery\Domain\Chat\Service;

use Nursery\Domain\Chat\Enum\MemberType;
use Nursery\Domain\Shared\Repository\AgentRepositoryInterface;
use Nursery\Domain\Shared\Repository\CustomerRepositoryInterface;
use Nursery\Domain\Shared\User\UserDomainInterface;

readonly class MemberService
{
    public function __construct(
        private AgentRepositoryInterface $agentRepository,
        private CustomerRepositoryInterface $customerRepository,
    ) {
    }

    public function getMember(MemberType $type, int $memberId): ?UserDomainInterface
    {
        return match ($type) {
            MemberType::Agent => $this->agentRepository->search($memberId),
            MemberType::Customer => $this->customerRepository->search($memberId),
        };
    }
}
