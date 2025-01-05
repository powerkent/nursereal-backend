<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Doctrine\ORM\EntityNotFoundException;
use Exception;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\HttpFoundation\Request;
use Nursery\Application\Shared\Query\FindChildByUuidOrIdQuery;
use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Payload\TreatmentPayload;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\TreatmentResource;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\TreatmentResourceFactory;

/**
 * @implements ProcessorInterface<TreatmentPayload, TreatmentResource>
 */
final readonly class TreatmentProcessor implements ProcessorInterface
{
    public function __construct(
        private QueryBusInterface $queryBus,
        private ChildProcessor $childProcessor,
        private TreatmentResourceFactory $treatmentResourceFactory,
    ) {
    }

    /**
     * @param  TreatmentPayload $data
     * @throws Exception
     */
    public function process($data, Operation $operation, array $uriVariables = [], array $context = []): TreatmentResource
    {
        /** @var Request|null $request */
        $request = $context['request'] ?? null;

        if (!$request instanceof Request) {
            throw new InvalidArgumentException('Invalid request type in context.');
        }

        /** @var InputBag<string> $query */
        $query = $request->query;

        /** @var ?Child $child */
        $child = $this->queryBus->ask(new FindChildByUuidOrIdQuery((string) $query->get('child_uuid')));

        if (null === $child) {
            throw new EntityNotFoundException(Child::class);
        }

        $treatment = $this->childProcessor->createTreatment($child, $data);
        $child->addTreatment($treatment);

        return $this->treatmentResourceFactory->fromModel($treatment);
    }
}
