<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Symfony;

use Nursery\ApiPlatform\OpenApi\OpenApiContextInterface;
use Nursery\Domain\Shared\Command\CommandHandlerInterface;
use Nursery\Domain\Shared\Event\EventHandlerInterface;
use Nursery\Domain\Shared\Query\QueryHandlerInterface;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use function sprintf;

/**
 * @codeCoverageIgnore
 */
class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    protected function configureContainer(ContainerConfigurator $container): void
    {
        $container->import(sprintf('%s/config/{packages}/*.php', $this->getProjectDir()));
        $container->import(sprintf('%s/config/{packages}/%s/*.php', $this->getProjectDir(), $this->environment));

        $container->import(sprintf('%s/config/{services}/*.php', $this->getProjectDir()));
        $container->import(sprintf('%s/config/{services}/%s/*.php', $this->getProjectDir(), $this->environment));
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $routes->import(sprintf('%s/config/{routes}/%s/*.php', $this->getProjectDir(), $this->environment));
        $routes->import(sprintf('%s/config/{routes}/*.php', $this->getProjectDir()));
    }

    protected function build(ContainerBuilder $container): void
    {
        $container->registerForAutoconfiguration(QueryHandlerInterface::class)
            ->addTag('messenger.message_handler', ['bus' => 'query.bus']);

        $container->registerForAutoconfiguration(CommandHandlerInterface::class)
            ->addTag('messenger.message_handler', ['bus' => 'command.bus']);

        $container->registerForAutoconfiguration(EventHandlerInterface::class)
            ->addTag('messenger.message_handler', ['bus' => 'event.bus']);

        $container->registerForAutoconfiguration(OpenApiContextInterface::class)
            ->addTag('shared.resource.open_api_context');
    }
}
