<?php

namespace a9f\Fractor\Tests\Configuration;

use a9f\Fractor\Configuration\FractorConfig;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(FractorConfig::class)]
final class FractorConfigTest extends TestCase
{
    #[Test]
    public function importFileIncludesFileAndCallsReturnedClosure(): void
    {
        $subject = new FractorConfig();

        $GLOBALS['called'] = false;
        $closure = <<<CODE
<?php

use a9f\Fractor\Configuration\FractorConfig;

return static function (FractorConfig \$config) {
    \$GLOBALS['called'] = true;
};
CODE;
        $this->placeConfigFileInTemporaryFolderAndImport($subject, $closure);

        self::assertTrue($GLOBALS['called']);
    }

    #[Test]
    public function importFileThrowsExceptionIfNoClosureIsReturned(): void
    {
        $subject = new FractorConfig();

        $this->expectException(\RuntimeException::class);

        $closure = <<<CODE
<?php

// no-op to provoke an error
CODE;
        $this->placeConfigFileInTemporaryFolderAndImport($subject, $closure);
    }

    private function placeConfigFileInTemporaryFolderAndImport(FractorConfig $config, string $closure): void
    {
        $tempFile = tempnam(sys_get_temp_dir(), 'fractor-test');
        try {
            file_put_contents($tempFile, $closure);

            $config->import($tempFile);
        } finally {
            if (file_exists($tempFile)) {
                unlink($tempFile);
            }
        }
    }
}