<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Security;

use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class JwtAuthenticator extends AbstractAuthenticator
{
    public function __construct(
        private JWTEncoderInterface $encoder
    ) {
    }

    public function supports(Request $request): ?bool
    {
        return $request->headers->has('Authorization');
    }

    public function authenticate(Request $request): SelfValidatingPassport
    {
        if (null === $auth = $request->headers->get('Authorization')) {
            throw new AuthenticationException('Authorization header missing');
        }

        $token = str_replace('Bearer ', '', $auth);

        try {
            $payload = $this->encoder->decode($token);

            if (!$payload || !isset($payload['username'])) {
                throw new AuthenticationException('Invalid JWT token');
            }

            return new SelfValidatingPassport(new UserBadge($payload['username']));
        } catch (\Exception $e) {
            throw new AuthenticationException('Invalid JWT Token');
        }
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null; // Allow the request to continue
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): Response
    {
        return new Response('Authentication failed', Response::HTTP_UNAUTHORIZED);
    }
}
