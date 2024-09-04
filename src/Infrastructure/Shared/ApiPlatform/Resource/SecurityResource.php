<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\Resource;

use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\ApiResource;
use Nursery\Infrastructure\Shared\ApiPlatform\Action\LogoutAction;

#[ApiResource(
    shortName: 'Security',
    operations: [
        new GetCollection(
            uriTemplate: '/logout',
            status: 204,
            controller: LogoutAction::class,
            read: false,
            name: 'logout',
        ),
    ],
    paginationEnabled: false
)]
final class SecurityResource
{
}
