<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Avatar\AvatarResource;
use Avatar\AvatarResourceFactory;
use Aws\Exception\AwsException;
use Aws\S3\S3Client;
use Doctrine\ORM\EntityManagerInterface;
use Nursery\Application\Shared\Command\Avatar\CreateAvatarCommand;
use Nursery\Domain\Shared\Command\CommandBusInterface;
use Nursery\Domain\Shared\Exception\EntityNotFoundException;
use Nursery\Domain\Shared\Exception\MissingPropertyException;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Input\AvatarInput;
use Ramsey\Uuid\Uuid;
use RuntimeException;

/**
 * @implements ProcessorInterface<AvatarInput, AvatarResource>
 */
final readonly class AvatarProcessor implements ProcessorInterface
{
    public function __construct(
        private QueryBusInterface $queryBus,
        private CommandBusInterface $commandBus,
        private AvatarResourceFactory $avatarResourceFactory,
        private S3Client $s3Client,
        private EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * @param AvatarInput $data
     */
    public function process($data, Operation $operation, array $uriVariables = [], array $context = []): AvatarResource
    {
        if (null === $data->file) {
            throw new MissingPropertyException(AvatarInput::class, 'file');
        }

        $bucket = 'avatar';

        $filename = uniqid('', true).'.'.$data->file->guessExtension();

        $class = $data->type->value;
        $queryClass = "Nursery\\Application\\Shared\\Query\\Find{$class}ByUuidOrIdQuery";

        if (!class_exists($queryClass)) {
            throw new RuntimeException("the class $queryClass does not exist.");
        }

        $object = $this->queryBus->ask(new $queryClass(uuid: $data->objectUuid));

        if (null === $object) {
            throw new EntityNotFoundException($queryClass, $data->objectUuid, 'uuid');
        }

        try {
            $this->ensureBucketExists($bucket);

            $this->s3Client->putObject([
                'Bucket'     => $bucket,
                'Key'        => $filename,
                'SourceFile' => $data->file->getPathname(),
                'ACL'        => 'public-read',
            ]);

            $objectUrl = $this->getPreSignedUrl($bucket, $filename);

            $avatar = $this->commandBus->dispatch(CreateAvatarCommand::create([
                'uuid' => Uuid::uuid4(),
                'contentUrl' => $objectUrl,
            ]));
        } catch (AwsException $e) {
            throw new RuntimeException('Unable to download on S3 : '.$e->getMessage());
        }

        $object->setAvatar($avatar);
        $this->entityManager->persist($object);
        $this->entityManager->flush();

        return $this->avatarResourceFactory->fromModel($avatar);
    }

    private function ensureBucketExists(string $bucket): void
    {
        try {
            $this->s3Client->headBucket(['Bucket' => $bucket]);
        } catch (AwsException $e) {
            if (404 === $e->getStatusCode()) {
                $this->s3Client->createBucket(['Bucket' => $bucket]);
                $this->s3Client->waitUntil('BucketExists', ['Bucket' => $bucket]);
            } else {
                throw $e;
            }
        }
    }

    private function getPreSignedUrl(string $bucket, string $filename): string
    {
        $cmd = $this->s3Client->getCommand('GetObject', [
            'Bucket' => $bucket,
            'Key'    => $filename,
        ]);

        $request = $this->s3Client->createPresignedRequest($cmd, '+60 minutes');

        return (string) $request->getUri();
    }
}
