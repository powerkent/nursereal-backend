<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Chat\Mercure\Provider;

use DateMalformedStringException;
use DateTimeImmutable;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key;
use Nursery\Domain\Chat\Security\JwtSignerInterface;
use RuntimeException;
use Symfony\Component\Mercure\Jwt\TokenProviderInterface;
use Throwable;
use Webmozart\Assert\Assert;

final class JwtProvider implements TokenProviderInterface, JwtSignerInterface
{
    private Configuration $configuration;

    public function __construct(
        string $key
    ) {
        Assert::notEmpty($key);
        $this->configuration = Configuration::forSymmetricSigner(
            signer: new Sha256(),
            key: Key\InMemory::plainText($key),
        );
    }

    /**
     * @throws DateMalformedStringException
     */
    public function getJwt(): string
    {
        $now = new DateTimeImmutable();

        $builder = $this->configuration->builder()
            ->issuedAt($now)
            ->canOnlyBeUsedAfter($now)
            ->expiresAt($now->modify('+1 hour'))
            ->withClaim('mercure', [
                'publish' => ['/channels/{channelId}'],
                'subscribe' => ['/channels/{channelId}'],
            ]);

        try {
            return $builder->getToken($this->configuration->signer(), $this->configuration->signingKey())->toString();
        } catch (Throwable $e) {
            throw new RuntimeException('Failed to generate JWT', 0, $e);
        }
    }
}
