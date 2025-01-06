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
        $payload['roles'] = $user->getRoles();
        $payload['id'] = $user->getId();
        $payload['uuid'] = $user->getUuid();

        $event->setData($payload);
    }
}
