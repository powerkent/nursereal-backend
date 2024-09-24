<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Security;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

class JWTCreatedListener
{
    public function onJWTCreated(JWTCreatedEvent $event): void
    {
        $user = $event->getUser();

        $payload = $event->getData();
        $payload['roles'] = $user->getRoles();

        /* @phpstan-ignore-next-line  */
        $payload['id'] = $user->getId();

        /* @phpstan-ignore-next-line  */
        $payload['uuid'] = $user->getUuid();

        $event->setData($payload);
    }
}
