<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Security;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Nursery\Domain\Shared\User\UserDomainInterface;

class JWTCreatedListener
{
    public function onJWTCreated(JWTCreatedEvent $event): void
    {
        /** @var UserDomainInterface $user */
        $user = $event->getUser();

        $payload = $event->getData();
        $payload['id'] = $user->getId();
        /* @phpstan-ignore-next-line  */
        $payload['roles'] = $user->getRoles();
        /* @phpstan-ignore-next-line  */
        $payload['uuid'] = $user->getUuid();

        $event->setData($payload);
    }
}
