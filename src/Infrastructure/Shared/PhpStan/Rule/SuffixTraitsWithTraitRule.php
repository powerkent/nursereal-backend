<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\PhpStan\Rule;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Node\InClassNode;
use PHPStan\Rules\IdentifierRuleError;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\ShouldNotHappenException;

/**
 * @implements Rule<InClassNode>
 * @codeCoverageIgnore
 */
final class SuffixTraitsWithTraitRule implements Rule
{
    private const string ERROR_MESSAGE = 'Trait name "%s" must be suffixed with "Trait"';

    public function getNodeType(): string
    {
        return InClassNode::class;
    }

    /**
     * @param InClassNode $node
     *
     * @return list<IdentifierRuleError>
     * @throws ShouldNotHappenException
     */
    public function processNode(Node $node, Scope $scope): array
    {
        $classReflection = $node->getClassReflection();
        if (!$classReflection->isTrait()) {
            return [];
        }

        $shortClassName = (string) $node->getOriginalNode()->name;
        if (str_ends_with($shortClassName, 'Trait')) {
            return [];
        }

        return [RuleErrorBuilder::message(sprintf(self::ERROR_MESSAGE, $shortClassName))->identifier('suffix.trait')->build()];
    }
}
