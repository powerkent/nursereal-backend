<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Action;

use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\Security\Http\Authenticator\JsonLoginAuthenticator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;


class AgentLoginAction
{
    public function __invoke(Request $request, UserAuthenticatorInterface $userAuthenticator, JsonLoginAuthenticator $authenticator): JsonResponse
    {
        return new JsonResponse(['message' => 'Successfully logged in']);
    }
}
