<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Symfony\DependencyInjection;

use Nursery\Infrastructure\Shared\Security\Voter;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use function array_keys;

/**
 * @codeCoverageIgnore
 */
final class VoterCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        foreach (array_keys($container->findTaggedServiceIds('shared.security.voter')) as $voterId) {
            $container->register(sprintf('shared.security.voter.%s', $voterId), Voter::class)
                ->addArgument(new Reference($voterId))
                ->addTag('security.voter');
        }
    }
}
