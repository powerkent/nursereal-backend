<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Chat\ApiPlatform\OpenApi;

use Nursery\Domain\Chat\Repository\ChannelRepositoryInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\OpenApi\OpenApiContextInterface;

/**
 * @codeCoverageIgnore
 */
final class MessageResourceOpenApiContext implements OpenApiContextInterface
{
    public function __construct(private ChannelRepositoryInterface $channelRepository)
    {
    }

    public function operations(): array
    {
        $channels = $this->channelRepository->all();
        $channelsValues = [];
        foreach ($channels as $channel) {
            $channelsValues[] = $channel->getId();
        }

        return [
            'GET /api/messages' => [
                'parameters' => [
                    [
                        'name' => 'channelId',
                        'in' => 'query',
                        'schema' => ['type' => 'string', 'enum' => $channelsValues],
                    ],
                ],
            ],
        ];
    }
}
