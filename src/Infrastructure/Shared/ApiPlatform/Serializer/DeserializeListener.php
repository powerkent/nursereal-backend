<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Serializer;

use ApiPlatform\State\SerializerContextBuilderInterface;
use ApiPlatform\State\Util\RequestAttributesExtractor;
use ApiPlatform\Symfony\EventListener\DeserializeListener as DecoratedListener;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use function array_merge;

readonly class DeserializeListener
{
    public function __construct(
        private DecoratedListener $decorated,
        private SerializerContextBuilderInterface $serializerContextBuilder,
        private DenormalizerInterface $denormalizer,
    ) {
    }

    /**
     * @throws ExceptionInterface
     */
    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();
        if ($request->isMethodCacheable() || $request->isMethod(Request::METHOD_DELETE)) {
            return;
        }

        if ($request->headers->get('Content-Type') && str_contains($request->headers->get('Content-Type'), 'multipart/form-data')) {
            $this->denormalizeFromRequest($request);
        } else {
            $this->decorated->onKernelRequest($event);
        }
    }

    /**
     * @throws ExceptionInterface
     */
    private function denormalizeFromRequest(Request $request): void
    {
        $attributes = RequestAttributesExtractor::extractAttributes($request);
        if (empty($attributes)) {
            return;
        }

        $context = $this->serializerContextBuilder->createFromRequest($request, false, $attributes);
        $populated = $request->attributes->get('data');
        if (null !== $populated) {
            $context['object_to_populate'] = $populated;
        }


        $data = $request->request->all();
        $files = $request->files->all();
        $object = $this->denormalizer->denormalize(
            array_merge($data, $files),
            $attributes['resource_class'],
            null,
            $context
        );

        $request->attributes->set('data', $object);
    }
}
