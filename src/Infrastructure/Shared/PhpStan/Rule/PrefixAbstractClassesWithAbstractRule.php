<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\PhpStan\Rule;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Node\InClassNode;
use PHPStan\Rules\Rule;

/**
 * @implements Rule<InClassNode>
 * @codeCoverageIgnore
 */
final class PrefixAbstractClassesWithAbstractRule implements Rule
{
    private const ERROR_MESSAGE = 'Abstract class name "%s" must be prefixed with "Abstract"';

    public function getNodeType(): string
    {
        return InClassNode::class;
    }

    /**
     * @param InClassNode $node
     *
     * @return array<string>
     */
    public function processNode(Node $node, Scope $scope): array
    {
        $classReflection = $node->getClassReflection();
        if (!$classReflection->isClass() || !$classReflection->isAbstract()) {
            return [];
        }

        $shortClassName = (string) $node->getOriginalNode()->name;
        if (str_starts_with($shortClassName, 'Abstract')) {
            return [];
        }

        return [sprintf(self::ERROR_MESSAGE, $shortClassName)];
    }
}
