<?php

declare(strict_types=1);

namespace a9f\FractorPhpStanRules\Rules;

use a9f\Fractor\Application\Contract\FractorRule;
use a9f\Fractor\Contract\NoChangelogRequired;
use PhpParser\Comment\Doc;
use PhpParser\Node;
use PhpParser\Node\Identifier;
use PhpParser\Node\Stmt\Class_;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Rules\Rule;
use PHPStan\Type\FileTypeMapper;

/**
 * @implements Rule<Class_>
 */
final class AddChangelogDocBlockForFractorRule implements Rule
{
    /**
     * @var string
     */
    public const ERROR_MESSAGE = 'Provide @changelog doc block for "%s" Fractor rule';

    /**
     * @readonly
     */
    private ReflectionProvider $reflectionProvider;

    /**
     * @readonly
     */
    private FileTypeMapper $fileTypeMapper;

    public function __construct(ReflectionProvider $reflectionProvider, FileTypeMapper $fileTypeMapper)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->fileTypeMapper = $fileTypeMapper;
    }

    public function getNodeType(): string
    {
        return Class_::class;
    }

    /**
     * @param Class_ $node
     */
    public function processNode(Node $node, Scope $scope): array
    {
        $className = $node->name;

        if (! $className instanceof Identifier) {
            return [];
        }

        $fullyQualifiedClassName = $scope->getNamespace() . '\\' . $className;

        if (! $this->reflectionProvider->hasClass($fullyQualifiedClassName)) {
            return [];
        }

        $classReflection = $this->reflectionProvider->getClass($fullyQualifiedClassName);
        if ($classReflection->isAbstract()) {
            return [];
        }

        if ($classReflection->isAnonymous()) {
            return [];
        }

        if (! $classReflection->isSubclassOf(FractorRule::class)) {
            return [];
        }

        if ($classReflection->isSubclassOf(NoChangelogRequired::class)) {
            return [];
        }

        $docComment = $node->getDocComment();
        if (! $docComment instanceof Doc) {
            return [sprintf(self::ERROR_MESSAGE, $className)];
        }

        $resolvedPhpDoc = $this->fileTypeMapper->getResolvedPhpDoc(
            $scope->getFile(),
            $classReflection->getName(),
            null,
            null,
            $docComment->getText()
        );

        $phpDocString = $resolvedPhpDoc->getPhpDocString();
        if (strpos($phpDocString, '@changelog') !== false) {
            return [];
        }

        return [sprintf(self::ERROR_MESSAGE, $className)];
    }
}
