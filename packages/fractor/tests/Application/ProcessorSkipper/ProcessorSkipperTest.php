<?php

declare(strict_types=1);

namespace a9f\Fractor\Tests\Application\ProcessorSkipper;

use a9f\Fractor\Application\ProcessorSkipper;
use a9f\Fractor\Configuration\ValueObject\SkipConfiguration;
use a9f\FractorFluid\FluidFileProcessor;
use a9f\FractorHtaccess\HtaccessFileProcessor;
use a9f\FractorTypoScript\TypoScriptFileProcessor;
use a9f\FractorXml\XmlFileProcessor;
use a9f\FractorYaml\YamlFileProcessor;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class ProcessorSkipperTest extends TestCase
{
    #[Test]
    public function processorNotInSkipListIsNotSkipped(): void
    {
        $configuration = new SkipConfiguration([]);
        $subject = new ProcessorSkipper($configuration);

        foreach (self::allProcessorClasses() as $processorClass) {
            self::assertFalse($subject->shouldSkip($processorClass));
        }
    }

    /**
     * @return \Generator<string, array{string}>
     */
    public static function skippableProcessorProvider(): \Generator
    {
        foreach (self::allProcessorClasses() as $processorClass) {
            $shortName = (new \ReflectionClass($processorClass))->getShortName();
            yield $shortName => [$processorClass];
        }
    }

    #[Test]
    #[DataProvider('skippableProcessorProvider')]
    public function singleProcessorInSkipListIsSkipped(string $processorClass): void
    {
        $configuration = new SkipConfiguration([$processorClass]);
        $subject = new ProcessorSkipper($configuration);

        self::assertTrue($subject->shouldSkip($processorClass));
    }

    #[Test]
    #[DataProvider('skippableProcessorProvider')]
    public function otherProcessorsAreNotAffectedWhenOneIsSkipped(string $skippedProcessor): void
    {
        $configuration = new SkipConfiguration([$skippedProcessor]);
        $subject = new ProcessorSkipper($configuration);

        foreach (self::allProcessorClasses() as $processor) {
            if ($processor === $skippedProcessor) {
                self::assertTrue($subject->shouldSkip($processor), $processor . ' should be skipped');
            } else {
                self::assertFalse($subject->shouldSkip($processor), $processor . ' should not be skipped');
            }
        }
    }

    #[Test]
    public function multipleProcessorsCanBeSkippedSimultaneously(): void
    {
        $configuration = new SkipConfiguration([
            FluidFileProcessor::class,
            XmlFileProcessor::class,
            YamlFileProcessor::class,
        ]);
        $subject = new ProcessorSkipper($configuration);

        self::assertTrue($subject->shouldSkip(FluidFileProcessor::class));
        self::assertFalse($subject->shouldSkip(HtaccessFileProcessor::class));
        self::assertFalse($subject->shouldSkip(TypoScriptFileProcessor::class));
        self::assertTrue($subject->shouldSkip(XmlFileProcessor::class));
        self::assertTrue($subject->shouldSkip(YamlFileProcessor::class));
    }

    #[Test]
    public function allProcessorsCanBeSkipped(): void
    {
        $configuration = new SkipConfiguration(self::allProcessorClasses());
        $subject = new ProcessorSkipper($configuration);

        foreach (self::allProcessorClasses() as $processorClass) {
            self::assertTrue($subject->shouldSkip($processorClass));
        }
    }

    /**
     * @return list<class-string>
     */
    private static function allProcessorClasses(): array
    {
        return [
            FluidFileProcessor::class,
            HtaccessFileProcessor::class,
            TypoScriptFileProcessor::class,
            XmlFileProcessor::class,
            YamlFileProcessor::class,
        ];
    }
}
