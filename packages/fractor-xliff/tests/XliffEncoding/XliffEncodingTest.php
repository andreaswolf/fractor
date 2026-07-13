<?php

declare(strict_types=1);

namespace a9f\FractorXliff\Tests\XliffEncoding;

use a9f\Fractor\Application\FractorRunner;
use a9f\Fractor\Configuration\ConfigurationRuleFilter;
use a9f\Fractor\Configuration\ValueObject\Configuration;
use a9f\Fractor\Testing\PHPUnit\AbstractFractorTestCase;
use Nette\Utils\FileSystem;
use PHPUnit\Framework\Attributes\DataProvider;

/**
 * Non-ASCII characters must stay literal and never be written as numeric entities.
 */
final class XliffEncodingTest extends AbstractFractorTestCase
{
    private ?string $inputFile = null;

    protected function tearDown(): void
    {
        if (\is_string($this->inputFile)) {
            FileSystem::delete($this->inputFile);
            $this->inputFile = null;
        }

        parent::tearDown();
    }

    public function provideConfigFilePath(): string
    {
        return __DIR__ . '/config/fractor.php';
    }

    /**
     * @param non-empty-string $fixture
     * @param non-empty-string $expectedText
     */
    #[DataProvider('provideNonAsciiFixtures')]
    public function testNonAsciiCharactersAreKeptLiteral(string $fixture, string $expectedText): void
    {
        $result = $this->fixAndRead($fixture);

        self::assertStringContainsString($expectedText, $result);
        self::assertStringNotContainsString('&#', $result);
    }

    /**
     * @return array<string, array{string, string}>
     */
    public static function provideNonAsciiFixtures(): array
    {
        return [
            // A missing declaration leaves the encoding empty; that is what turned
            // "für" into "f&#xFC;r" during serialisation.
            'german umlauts, no declaration' => [
                'umlauts-no-declaration.xlf',
                'Ergebnisse für "%s". Ä Ö Ü ä ö ü ß',
            ],
            'german umlauts, with declaration' => [
                'umlauts-with-declaration.xlf',
                'Ergebnisse für "%s". Ä Ö Ü ä ö ü ß',
            ],
            'french accents, no declaration' => ['french-accents.xlf', 'Résultats à côté, déjà vu'],
            'symbols and dashes, no declaration' => ['symbols.xlf', 'Preis: 5€ – naïve façade'],
        ];
    }

    public function testNonAsciiSurvivesAlongsideRuleChange(): void
    {
        // One unit triggers the rule, the other carries non-ASCII text: the rule
        // change must apply and the umlauts must stay literal.
        $result = $this->fixAndRead('umlaut-and-rule-change.xlf');

        self::assertStringContainsString('Hello World', $result);
        self::assertStringContainsString('Ergebnisse für "%s".', $result);
        self::assertStringNotContainsString('&#', $result);
    }

    private function fixAndRead(string $fixture): string
    {
        $this->inputFile = sys_get_temp_dir() . '/fractor-xliff-' . uniqid() . '.xlf';
        FileSystem::write($this->inputFile, FileSystem::read(__DIR__ . '/Fixtures/' . $fixture), null);

        $configuration = new Configuration(
            dryRun: false,
            showProgressBar: false,
            fileExtensions: ['xlf', 'xliff'],
            paths: [$this->inputFile],
        );

        $this->getService(ConfigurationRuleFilter::class)->setConfiguration($configuration);
        $this->getService(FractorRunner::class)->run($configuration);

        return FileSystem::read($this->inputFile);
    }
}
