# TYPO3-Fractor – An enhancement for [TYPO3-Rector](https://github.com/sabbelasichon/typo3-rector)

Ease your TYPO3 upgrades by also automatically change TypoScript, YAML and Fluid.

> [!WARNING]
> :heavy_exclamation_mark: Never run this tool on production! Always run it on development environment where code is under version control (e.g. git).
> Review and test changes before releasing to production. Code migrations could potentionally break your website!

## Installation

Install typo3-fractor via composer by running the following command in your terminal:

```
composer require a9f/typo3-fractor --dev
```

## Configuration
Create a PHP configuration file (e.g., fractor.php`) where you define the paths to your files and the rules to apply.

```php
<?php
    
use a9f\Fractor\DependencyInjection\FractorConfiguration;      

return FractorConfiguration::configure()
    ->withPaths([__DIR__ . '/packages/'])
    ->withSets([
        Typo3LevelSetList::UP_TO_TYPO3_13
    ]);
```

Have a look at all available rules [Overview of all rules](docs/typo3-fractor-rules.md)

## Usage

Execute it from the command line:
```
./vendor/bin/fractor process
```

Fractor will apply the rules specified in the configuration file to the targeted files.

Review the changes to ensure they meet your expectations.


