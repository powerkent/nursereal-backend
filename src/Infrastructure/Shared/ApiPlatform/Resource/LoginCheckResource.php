<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use Nursery\Infrastructure\Shared\ApiPlatform\Action\AgentLoginAction;
use Nursery\Infrastructure\Shared\ApiPlatform\Action\CustomerLoginAction;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    shortName: 'LoginCheck',
    operations: [
        new Post(
            uriTemplate: '/customers/login',
            controller: CustomerLoginAction::class,
            name: 'api_customers_login',
        ),
        new Post(
            uriTemplate: '/agents/login',
            controller: AgentLoginAction::class,
            name: 'api_agents_login',
        ),
    ],
)]
final class LoginCheckResource
{
}
