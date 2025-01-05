<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\OpenApi;

use ApiPlatform\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\OpenApi\Model\Operation;
use ApiPlatform\OpenApi\Model\PathItem;
use ApiPlatform\OpenApi\Model\Paths;
use ApiPlatform\OpenApi\OpenApi;
use RuntimeException;

final readonly class ResourceMetadataFactory implements OpenApiFactoryInterface
{
    /**
     * @param array<OpenApiContextInterface> $resources
     */
    public function __construct(
        private OpenApiFactoryInterface $decorated,
        private iterable $resources,
    ) {
    }

    /**
     * @param array<string, mixed> $context
     */
    public function __invoke(array $context = []): OpenApi
    {
        $openApi = $this->decorated->__invoke($context);
        $paths = $openApi->getPaths();

        foreach ($this->resources as $resource) {
            foreach ($resource->operations() as $iri => $doc) {
                $iriSplit = explode(' ', $iri);
                [$httpVerb, $url] = $iriSplit;
                $openApi->getPaths()->addPath($url, $this->buildOperationDoc($paths, $url, $httpVerb, $doc));
            }
        }

        return $openApi;
    }

    /**
     * @param array<string, mixed> $params
     */
    private function buildOperationDoc(Paths $paths, string $uuid, string $httpVerb, array $params): PathItem
    {
        $pathItem = $paths->getPath($uuid);
        if (null === $pathItem) {
            throw new RuntimeException('Item path needed to build operation doc');
        }

        $getMethod = sprintf('get%s', ucfirst(strtolower($httpVerb)));
        /* @var Operation $operation */
        $operation = $pathItem->$getMethod();

        foreach ($params as $param => $value) {
            switch ($param) {
                case 'responses':
                    $operation = $operation->withResponses($value);
                    break;
                case 'summary':
                    $operation = $operation->withSummary($value);
                    break;
                case 'operation_id':
                    $operation = $operation->withOperationId($value);
                    break;
                case 'requestBody':
                    $operation = $operation->withRequestBody($value);
                    break;
                case 'description':
                    $operation = $operation->withDescription($value);
                    break;
                case 'parameters':
                    $operation = $operation->withParameters(array_merge($operation->getParameters(), $value));
                    break;
            }
        }

        $withMethod = sprintf('with%s', ucfirst(strtolower($httpVerb)));

        return $pathItem->$withMethod($operation);
    }
}
