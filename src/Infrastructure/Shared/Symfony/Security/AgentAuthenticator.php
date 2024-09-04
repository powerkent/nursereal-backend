<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\Symfony\Security;


use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

final class AgentAuthenticator extends AbstractAuthenticator
{
    public function __construct(
        private JWTTokenManagerInterface $jwtEncoder,
    ) {
    }

    public function supports(Request $request): ?bool
    {
        return str_starts_with($request->headers->get('authorization', ''), 'Bearer ');
    }

    public function authenticate(Request $request): Passport
    {
        $token = trim(str_replace('Bearer', '', $request->headers->get('authorization') ?? ''));

        if ('' === $token) {
            throw new CustomUserMessageAuthenticationException('token is empty');
        }

        $payload = $this->jwtEncoder->parse($token);


        return new SelfValidatingPassport(new UserBadge($payload['email']));
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        if ('/api/logout' === $request->getPathInfo()) {
            return new JsonResponse('', Response::HTTP_NO_CONTENT);
        }

        $data = ['message' => strtr($exception->getMessageKey(), $exception->getMessageData())];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }
}
