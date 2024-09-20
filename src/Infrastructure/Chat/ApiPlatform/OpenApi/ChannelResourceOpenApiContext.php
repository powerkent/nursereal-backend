<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Chat\ApiPlatform\OpenApi;

use Nursery\Domain\Chat\Repository\MemberRepositoryInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\OpenApi\OpenApiContextInterface;

/**
 * @codeCoverageIgnore
 */
final class ChannelResourceOpenApiContext implements OpenApiContextInterface
{
    public function __construct(private MemberRepositoryInterface $memberRepository)
    {
    }

    public function operations(): array
    {
        $members = $this->memberRepository->all();
        $membersValues = [];
        foreach ($members as $member) {
            $membersValues[] = $member->getMemberId();
        }

        return [
            'GET /api/channels' => [
                'parameters' => [
                    [
                        'name' => 'memberId',
                        'in' => 'query',
                        'schema' => ['type' => 'string', 'enum' => $membersValues],
                    ],
                ],
            ],
        ];
    }
}
