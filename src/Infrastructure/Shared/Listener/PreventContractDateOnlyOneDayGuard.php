<?php

declare(strict_types=1);

namespace Nusery\Infrastructure\Shared\Listener;

use DateTimeImmutable;
use Nursery\Domain\Shared\Exception\ContractDateShouldHaveSameDayDateException;
use Nursery\Domain\Shared\Exception\MissingPropertyException;
use Nursery\Domain\Shared\Listener\GuardInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use function json_decode;

class PreventContractDateOnlyOneDayGuard implements GuardInterface
{
    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        if ('/api/contract_dates' !== $request->getPathInfo() || 'POST' !== $request->getMethod()) {
            return;
        }

        $data = json_decode($request->getContent(), true);

        if (empty($data['contractDates'])) {
            throw new MissingPropertyException(self::class, 'contractDates');
        }

        foreach ($data['contractDates'] as $contractDate) {
            if ((new DateTimeImmutable($contractDate['contractTimeStart']))->format('Y-m-d') !== (new DateTimeImmutable($contractDate['contractTimeEnd']))->format('Y-m-d')) {
                throw new ContractDateShouldHaveSameDayDateException();
            }
        }
    }
}
