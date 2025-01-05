<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Chat\ApiPlatform\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use DateTimeImmutable;
use Nursery\Application\Chat\Command\CreateMessageCommand;
use Nursery\Application\Chat\Query\FindChannelByIdQuery;
use Nursery\Application\Chat\Query\FindMemberByMemberTypeAndMemberIdQuery;
use Nursery\Domain\Chat\Enum\MemberType;
use Nursery\Domain\Chat\Model\Message;
use Nursery\Domain\Chat\Service\MemberService;
use Nursery\Domain\Shared\Command\CommandBusInterface;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Domain\Shared\User\UserDomainInterface;
use Nursery\Infrastructure\Chat\ApiPlatform\Input\MessageInput;
use Nursery\Infrastructure\Chat\ApiPlatform\Resource\MessageResource;
use Nursery\Infrastructure\Chat\ApiPlatform\Resource\MessageResourceFactory;
use RuntimeException;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;

/**
 * @implements ProcessorInterface<MessageInput, MessageResource>
 */
final readonly class MessageProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private QueryBusInterface $queryBus,
        private MessageResourceFactory $messageResourceFactory,
        private MemberService $memberService,
        private HubInterface $publisher,
    ) {
    }

    /**
     * @param MessageInput $data
     */
    public function process($data, Operation $operation, array $uriVariables = [], array $context = []): MessageResource
    {
        $member = $this->queryBus->ask(new FindMemberByMemberTypeAndMemberIdQuery(
            type: $type = MemberType::from($data->author->memberType),
            memberId: $data->author->memberId,
        ));

        $member->addChannel($channel = $this->queryBus->ask(new FindChannelByIdQuery($data->channelId)));

        $primitives = [
            'content' => $data->content,
            'author' => $member,
            'channel' => $channel,
            'createdAt' => $createdAt = new DateTimeImmutable(),
        ];

        /** @var Message $message */
        $message = $this->commandBus->dispatch(CreateMessageCommand::create($primitives));

        /** @var UserDomainInterface $author */
        $author = $this->memberService->getMember($type, $member->getMemberId());
        $payload = json_encode([
            'content' => $message->getContent(),
            'author' => [
                'id' => $author->getId(),
                'firstname' => $author->getFirstname(),
                'lastname' => $author->getLastname(),
            ],
            'createdAt' => $createdAt->format(DateTimeImmutable::ATOM),
        ]);

        if (!$payload) {
            throw new RuntimeException('Unable to process message because it\'s not json encodable');
        }

        $mercureUpdate = new Update(
            topics: sprintf('/channels/%d', $data->channelId),
            data: $payload,
        );

        $this->publisher->publish($mercureUpdate);

        return $this->messageResourceFactory->fromModel($message);
    }
}
