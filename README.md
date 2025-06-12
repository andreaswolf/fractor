# Fractor – a generic file refactoring tool

Fractor is a generic tool for changing all kinds of files via defined rules—similar to what [Rector](https://github.com/rectorphp/rector/) does for PHP.

> [!WARNING]
> :heavy_exclamation_mark: Never run this tool on production! Always run it on development environment where code is under version control (e.g. git).
> Review and test changes before releasing to production. Code migrations could potentially break your website!

## How it works

The main package `a9f/fractor` provides infrastructure for configuring, running and extending Fractor,
but no rules for changing any files.
These are provided by individual packages specific for different file types
(like `a9f/fractor-composer-json`, `a9f/fractor-xml` or `a9f/fractor-yaml`) or ecosystems (like `a9f/typo3-fractor`).

For different file types, different operation modes are possible.
For XML, there is a full-blown tree traversal implemented in `a9f/fractor-xml`,
allowing extensions to listen to single nodes in a very similar fashion to Rector.

In principle, this is also possible for e.g. JSON or YAML files
if they are converted into a tree-like data structure.
Such a structure also provides advantages in keeping formatting intact as much as possible.
However, since PHP does not have strong parsers for these formats that emit an AST for them,
there is no advanced support available right now.

### Rules overview

* Available rules for composer.json files are documented in [the fractor-composer-json package](./packages/fractor-composer-json/docs/composer-json-fractor-rules.md)
* Available rules for TYPO3 are documented in [the typo3-fractor package](./packages/typo3-fractor/docs/typo3-fractor-rules.md)

## Requirements

Fractor needs at least PHP 8.2.
If you want to migrate outdated systems, that don't support PHP 8.2, you can install Fractor, for example, in a Docker
container that is based on a PHP 8.2 image and then run it from there.
Alternatively, you can run Fractor within a CI Pipeline that is using PHP 8.2 and then commit the code changes within CI.

## Installation

If you want to migrate common files, you can specify the file types you want to support.
Fractor core will be installed automatically and doesn't need to be required directly.

Install Fractor with the file types you need via composer by running the following command in your terminal:

```bash
composer require a9f/fractor-composer-json a9f/fractor-htaccess a9f/fractor-xml a9f/fractor-yaml --dev
```

As **TYPO3** users, you probably want to use `a9f/typo3-fractor` only which will install all necessary file types for
you like fluid, htaccess, typoscript, xml and yaml:

```bash
composer require a9f/typo3-fractor --dev
```

## Configuration

Create a PHP configuration file (e.g., `fractor.php`) where you define the paths to your files.
At minimum, a configuration file must specify the paths to process:

```php
<?php

use a9f\Fractor\Configuration\FractorConfiguration;
use a9f\Typo3Fractor\Set\Typo3LevelSetList;

return FractorConfiguration::configure()
    ->withPaths([__DIR__ . '/packages/'])
    ->withSets([
        Typo3LevelSetList::UP_TO_TYPO3_14
    ]);
```

If you want to apply only one specific rule, you can do so:

```php
<?php

use a9f\Fractor\Configuration\FractorConfiguration;
use a9f\Typo3Fractor\TYPO3v7\FlexForm\AddRenderTypeToFlexFormFractor;
use a9f\FractorComposerJson\AddPackageToRequireDevComposerJsonFractor;

return FractorConfiguration::configure()
    ->withPaths([__DIR__ . '/packages/'])
    ->withConfiguredRule(
        AddPackageToRequireDevComposerJsonFractor::class,
        [new PackageAndVersion('vendor1/package3', '^3.0')]
    )
    ->withRules([AddRenderTypeToFlexFormFractor::class]);
```

You can also skip some rules or files and folders. Do it the following way:

```php
<?php

use a9f\Fractor\Configuration\FractorConfiguration;
use a9f\Typo3Fractor\Set\Typo3LevelSetList;

return FractorConfiguration::configure()
    ->withPaths([__DIR__ . '/packages/'])
    ->withSkip([
        AddRenderTypeToFlexFormFractor::class,
        __DIR__ . '/packages/my_package/crappy_file.txt',
        __DIR__ . '/packages/my_package/other_crappy_file.txt' => [
            AddRenderTypeToFlexFormFractor::class,
        ]
    ])
    ->withSets([
        Typo3LevelSetList::UP_TO_TYPO3_14
    ]);
```

### Configure code style

Fractor tries to format the code as good as possible.
If you want to adjust the indentation of your xml files, you can configure it this way:

```php
<?php

use a9f\Fractor\Configuration\FractorConfiguration;
use a9f\Fractor\ValueObject\Indent;
use a9f\FractorXml\Configuration\XmlProcessorOption;

return FractorConfiguration::configure()
    ->withOptions([
        XmlProcessorOption::INDENT_CHARACTER => Indent::STYLE_TAB,
        XmlProcessorOption::INDENT_SIZE => 1,
    ]);
```

If you want to adjust the format of your TypoScript files, you can configure it this way:

```php
<?php

use a9f\Fractor\Configuration\FractorConfiguration;
use a9f\FractorTypoScript\Configuration\TypoScriptProcessorOption;
use Helmich\TypoScriptParser\Parser\Printer\PrettyPrinterConfiguration;

return FractorConfiguration::configure()
    ->withOptions([
        TypoScriptProcessorOption::INDENT_SIZE => 2,
        TypoScriptProcessorOption::INDENT_CHARACTER => PrettyPrinterConfiguration::INDENTATION_STYLE_SPACES,
        TypoScriptProcessorOption::ADD_CLOSING_GLOBAL => false,
        TypoScriptProcessorOption::INCLUDE_EMPTY_LINE_BREAKS => true,
        TypoScriptProcessorOption::INDENT_CONDITIONS => true,
        TypoScriptProcessorOption::CONDITION_TERMINATION => PrettyPrinterConditionTermination::Keep,
    ]);
```

Possible values for `TypoScriptProcessorOption::INDENT_CHARACTER`:

- `PrettyPrinterConfiguration::INDENTATION_STYLE_SPACES` will use spaces
- `PrettyPrinterConfiguration::INDENTATION_STYLE_TABS` will use tabs
- `'auto'` will detect the indentation from the file and keep it

Possible values for `TypoScriptProcessorOption::CONDITION_TERMINATION`:

- `PrettyPrinterConditionTermination::Keep` will keep existing termination
- `PrettyPrinterConditionTermination::EnforceGlobal` will always end with `[global]`
- `PrettyPrinterConditionTermination::EnforceEnd` will always end with `[end]`

## Processing

Before executing the code migrations, run the following command to see a preview of what Fractor will do:

```bash
vendor/bin/fractor process --dry-run
```

Fractor will output all the potential changes on the console without real execution.

Review the changes made by Fractor to ensure they meet your expectations.
If you see some things that Fractor should not migrate for some reason, adjust your config file and exclude either rules,
some paths or single files.

When you feel confident, execute the code migrations with the following command:

```bash
vendor/bin/fractor process
```

Fractor will now apply the rules specified in the configuration file to the targeted files.

## Customization

You can modify existing rules or create new ones to tailor Fractor's behavior to your specific needs.
See the "Extending Fractor" section for guidance on creating custom rules.

## Extending Fractor

Fractor can be extended with additional transformation rules and support for new file types.

### Adding Custom Rules

Here's how you can extend Fractor with a custom rule:

#### Creating New Rules

- Create a new rule by subclassing the appropriate rule class for the file type,
  e.g. `\a9f\FractorXml\XmlFractor` for XML files.
- Each rule should specify the conditions under which it should be applied and the corresponding changes to be made.
- Ideally, new rules also have a test case that validates that they work correctly.

#### Registering New Rules

- Register your custom rules within the Fractor configuration file.

### Supporting New File Types

- To support a new file type, you will need to implement an instance of `\a9f\Fractor\Fractor\FileProcessor`.
  This processor must take care of decoding a file and then traversing the decoded file structure
  (e.g., the DOM tree of an XML file; see `\a9f\FractorXml\XmlFileProcessor` for an example)

### Testing

- Thoroughly test your extensions to ensure they function as expected and do not introduce unintended side effects.
- Write unit tests for your custom rules and parsers to maintain code quality and stability.

### Documentation

- Document your custom rules and file type extensions to aid other users in understanding and utilizing your contributions.

By extending Fractor in this manner, you can enhance its capabilities and adapt it to handle a wider range of file formats
and transformation scenarios.

## Contributing

If you encounter any issues or have suggestions for improvements,
we welcome contributions from the community. Here's how you can contribute:

1. Fork the repository.
2. Make your changes.
3. Run `composer run-script local:contribute`
4. Submit a pull request with a clear description of your changes and why they are needed.

## Support

For any questions or support regarding Fractor, please open an issue on GitHub. We'll do our best to help you promptly.

## License

Fractor is licensed under the MIT License.

## Acknowledgments

Fractor wouldn't be possible without the amazing work of all the open source libraries we rely on.
A special mention goes to [Rector](https://github.com/rectorphp/rector/) that inspired many of the concepts and implementations in Fractor.
We're grateful for all their contributions to the PHP ecosystem.

-----

Thank you for using Fractor to streamline your software update process!
We hope it helps to make your development workflow more efficient and enjoyable.
If you have any feedback or suggestions, we'd love to hear from you.

Happy coding! 🚀
