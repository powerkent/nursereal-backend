<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Chat\ApiPlatform\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\Pagination;
use Nursery\Application\Chat\Query\Message\FindMessagesByChannelIdQuery;
use Nursery\Domain\Chat\Model\Message;
use Nursery\Domain\Shared\Exception\EntityNotFoundException;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Chat\ApiPlatform\Resource\MessageResource;
use Nursery\Infrastructure\Chat\ApiPlatform\Resource\MessageResourceFactory;
use Nursery\Infrastructure\Shared\ApiPlatform\Provider\AbstractCollectionProvider;

/**
 * @extends AbstractCollectionProvider<Message, MessageResource>
 */
final class MessageCollectionProvider extends AbstractCollectionProvider
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
        private readonly MessageResourceFactory $messageResourceFactory,
        Pagination $pagination,
    ) {
        parent::__construct($pagination);
    }

    /**
     * @return array<int, Message>
     */
    public function collection(Operation $operation, array $uriVariables = [], array $filters = [], array $context = []): array
    {
        if (null === ($channelId = $context['filters']['channelId'])) {
            throw new EntityNotFoundException(Message::class, 0, 'id');
        }

        return $this->queryBus->ask(new FindMessagesByChannelIdQuery((int) $channelId));
    }

    /**
     * @param Message $model
     */
    protected function toResource($model): object
    {
        return $this->messageResourceFactory->fromModel($model);
    }
}
