<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Chat\ApiPlatform\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\Pagination;
use Nursery\Application\Chat\Query\FindChannelByIdQuery;
use Nursery\Application\Chat\Query\FindChannelsByMemberIdQuery;
use Nursery\Domain\Chat\Model\Channel;
use Nursery\Domain\Chat\Model\Member;
use Nursery\Domain\Shared\Exception\EntityNotFoundException;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Chat\ApiPlatform\Resource\ChannelResource;
use Nursery\Infrastructure\Chat\ApiPlatform\Resource\ChannelResourceFactory;
use Nursery\Infrastructure\Shared\ApiPlatform\Provider\AbstractCollectionProvider;

/**
 * @extends AbstractCollectionProvider<Channel, ChannelResource>
 */
final class ChannelCollectionProvider extends AbstractCollectionProvider
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
        private readonly ChannelResourceFactory $channelResourceFactory,
        Pagination $pagination,
    ) {
        parent::__construct($pagination);
    }

    /**
     * @return array<int, Channel>
     */
    public function collection(Operation $operation, array $uriVariables = [], array $filters = [], array $context = []): array
    {
        if (null === ($memberId = $context['filters']['memberId'] ?? null)) {
            throw new EntityNotFoundException(Member::class, 0, 'id');
        }

        $channels = $this->queryBus->ask(new FindChannelsByMemberIdQuery((int) $memberId));
        $chans = [];
        foreach ($channels as $channel) {
            $chans[] = $this->queryBus->ask(new FindChannelByIdQuery($channel['id']));
        }

        return $chans;
    }

    /**
     * @param Channel $model
     */
    protected function toResource($model): object
    {
        return $this->channelResourceFactory->fromModel($model);
    }
}
