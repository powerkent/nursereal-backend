<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Doctrine\Fixtures;

use Doctrine\Bundle\FixturesBundle\Fixture as DoctrineFixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;

abstract class AbstractFixtures extends DoctrineFixture
{
    public function __construct(private EntityManagerInterface $em)
    {
        $this->em->getClassMetadata(static::modelClass())->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);
    }

    /**
     * @return class-string
     */
    abstract protected static function modelClass(): string;
}
