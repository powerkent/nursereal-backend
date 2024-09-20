<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Chat\ApiPlatform\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use DateTimeImmutable;
use Nursery\Application\Chat\Command\CreateChannelCommand;
use Nursery\Application\Chat\Query\FindMemberByMemberTypeAndMemberIdQuery;
use Nursery\Domain\Chat\Enum\MemberType;
use Nursery\Domain\Chat\Model\Member;
use Nursery\Domain\Shared\Command\CommandBusInterface;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Chat\ApiPlatform\Input\ChannelInput;
use Nursery\Infrastructure\Chat\ApiPlatform\Resource\ChannelResource;
use Nursery\Infrastructure\Chat\ApiPlatform\Resource\ChannelResourceFactory;

/**
 * @implements ProcessorInterface<ChannelInput, ChannelResource>
 */
final readonly class ChannelProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private QueryBusInterface $queryBus,
        private ChannelResourceFactory $channelResourceFactory,
    ) {
    }

    /**
     * @param ChannelInput $data
     */
    public function process($data, Operation $operation, array $uriVariables = [], array $context = []): ChannelResource
    {
        $members = [];
        foreach ($data->members as $memberInput) {
            $memberType = MemberType::from($memberInput->memberType);
            if (null === $member = $this->queryBus->ask(new FindMemberByMemberTypeAndMemberIdQuery($memberType, $memberInput->memberId))) {
                $members[] = new Member(type: $memberType, memberId: $memberInput->memberId);
                continue;
            }
            $members[] = $member;
        }

        $primitives = [
            'name' => $data->name,
            'members' => $members,
            'createdAt' => new DateTimeImmutable(),
        ];

        $channel = $this->commandBus->dispatch(CreateChannelCommand::create($primitives));

        return $this->channelResourceFactory->fromModel($channel);
    }
}
