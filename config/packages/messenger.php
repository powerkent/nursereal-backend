<?php

declare(strict_types=1);

use Nursery\Domain\Shared\Command\CommandInterface;
use Nursery\Domain\Shared\Event\EventInterface;
use Nursery\Domain\Shared\Query\QueryInterface;
use Nursery\Infrastructure\Shared\Symfony\Messenger\Middleware\ExceptionConverterMiddleware;
use Symfony\Config\FrameworkConfig;

return static function (FrameworkConfig $config): void {
    $messenger = $config->messenger();

    $commandBus = $messenger->defaultBus('command.bus')->bus('command.bus');
    $commandBus->middleware()->id('validation');
    $commandBus->middleware()->id(ExceptionConverterMiddleware::class);

    $messenger->bus('query.bus')
        ->middleware()->id('validation');

    $eventBus = $messenger->bus('event.bus')->defaultMiddleware('allow_no_handlers');
    $eventBus->middleware()->id('validation');

    $messenger->transport('sync')->dsn('sync://');

    $messenger->transport('failed')
        ->dsn('doctrine://default')// Failed transport only store failed messages, no need for SQS here
        ->options([
            'auto_setup' => true,
            'queue_name' => 'failed',
        ])
    ;

    $messenger->routing(QueryInterface::class)->senders(['sync']);
    $messenger->routing(CommandInterface::class)->senders(['sync']);
    $messenger->routing(EventInterface::class)->senders(['sync']);
};
