<?php

declare(strict_types=1);

namespace Nusery\Infrastructure\Shared\Listener;

use Nursery\Domain\Shared\Exception\OnlyOneChildPerContractCalendarException;
use Nursery\Domain\Shared\Listener\GuardInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class PreventChildrenOnPostCalendarGuard implements GuardInterface
{
    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        if ('/api/contract_dates' !== $request->getPathInfo() || 'POST' !== $request->getMethod()) {
            return;
        }

        if (2 !== substr_count($request->getRequestUri(), 'child')) {
            throw new OnlyOneChildPerContractCalendarException();
        }
    }
}
