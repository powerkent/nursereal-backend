<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Processor\Agent;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Exception;
use Nursery\Application\Shared\Query\Agent\FindAgentByUuidOrIdQuery;
use Nursery\Domain\Shared\Exception\EntityNotFoundException;
use Nursery\Domain\Shared\Model\Agent;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Input\AgentEmailInput;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

/**
 * @implements ProcessorInterface<AgentEmailInput, bool>
 */
final readonly class AgentEmailPostProcessor implements ProcessorInterface
{
    public function __construct(
        private QueryBusInterface $queryBus,
        private MailerInterface $mailer,
    ) {
    }

    /**
     * @param  AgentEmailInput             $data
     * @throws Exception
     * @throws TransportExceptionInterface
     */
    public function process($data, Operation $operation, array $uriVariables = [], array $context = []): bool
    {
        /** @var ?Agent $agent */
        $agent = $this->queryBus->ask(new FindAgentByUuidOrIdQuery(uuid: $uuid = $uriVariables['uuid']));

        if (null === $agent) {
            throw new EntityNotFoundException(Agent::class, $uuid, 'uuid');
        }

        $email = new Email()
            ->from('quentin.lemoine62580@gmail.com')
            ->to($agent->getEmail())
            ->subject('Nursereal: Mdofication de votre compte')
            ->text(
                <<<TEXT
Bonjour {$agent->getFirstName()} {$agent->getLastName()},

Veuillez confirmer votre compte en suivant ce lien: http://localhost:3000/agents/edit/{$uuid}/confirmation

Cordialement,

Nursereal
TEXT
            );

        $this->mailer->send($email);

        return true;
    }
}
