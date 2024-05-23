# Fractor – a generic file refactoring tool

Fractor is a generic tool for changing all kinds of files via defined rules—similar to what [Rector](https://github.com/rectorphp/rector/) does for PHP.

## How it works

The main package `a9f/fractor` provides infrastructure for configuring, running and extending Fractor,
but no rules for changing any files.
These are provided by packages specific for file types (like `a9f/fractor-xml`)
or ecosystems (like `a9f/typo3-fractor`).

For different file types, different operation modes are possible.
For XML, there is a full-blown tree traversal implemented in `a9f/fractor-xml`,
allowing extensions to listen to single nodes in a very similar fashion to Rector.

In principle, this is also possible for e.g. JSON or YAML files
if they are converted into a tree-like data structure.
Such a structure also provides advantages in keeping formatting intact as much as possible.
However, since PHP does not have strong parsers for these formats that emit an AST for them,
there is no advanced support available right now.

## Installation

Install Fractor via composer by running the following command in your terminal:

```
composer require a9f/fractor a9f/fractor-xml --dev
```

## Configuration
Create a PHP configuration file (e.g., `fractor.php`) where you define the paths to your files.
At minimum, a configuration file must specify the paths to process:

```php
<?php

use a9f\Fractor\Configuration\FractorConfiguration;

return FractorConfiguration::configure()
    ->withPaths([__DIR__ . '/packages/'])
    ->withSets([
        Typo3LevelSetList::UP_TO_TYPO3_13
    ]);
```

If you want to apply only one specific rule you can do so:

```php
<?php

use a9f\Fractor\Configuration\FractorConfiguration;
use a9f\Typo3Fractor\TYPO3v7\FlexForm\AddRenderTypeToFlexFormFractor;
use a9f\FractorComposerJson\AddPackageToRequireDevComposerJsonFractorRule;

return FractorConfiguration::configure()
    ->withPaths([__DIR__ . '/packages/'])
    ->withConfiguredRule(AddPackageToRequireDevComposerJsonFractorRule::class, [new PackageAndVersion('vendor1/package3', '^3.0')]
    )
    ->withRules([AddRenderTypeToFlexFormFractor::class]);
```

You can even skip some rules or files and folders. Do it the following way:

```php
<?php

use a9f\Fractor\Configuration\FractorConfiguration;

return FractorConfiguration::configure()
    ->withPaths([__DIR__ . '/packages/'])
    ->withSkip([
        __DIR__ . '/packages/my_package/crappy_file.txt',
        AddRenderTypeToFlexFormFractor::class,
        __DIR__ . '/packages/my_package/other_crappy_file.txt' => [
            AddRenderTypeToFlexFormFractor::class,
        ]
    ])
    ->withSets([
        Typo3LevelSetList::UP_TO_TYPO3_13
    ]);
```

## Processing

Execute Fractor from the command line, passing the path to your configuration file as an argument:

```
./vendor/bin/fractor process -f fractor.php
```

Fractor will apply the rules specified in the configuration file to the targeted files.
Review the changes made by Fractor to ensure they meet your expectations.

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

#### Supporting New File Types
- To support a new file type, you will need to implement an instance of `\a9f\Fractor\Fractor\FileProcessor`.
This processor must take care of decoding a file and then traversing the decoded file structure
(e.g. the DOM tree of an XML file; see `\a9f\FractorXml\XmlFileProcessor` for an example)

### Testing
- Thoroughly test your extensions to ensure they function as expected and do not introduce unintended side effects.
- Write unit tests for your custom rules and parsers to maintain code quality and stability.

### Documentation
- Document your custom rules and file type extensions to aid other users in understanding and utilizing your contributions.

By extending Fractor in this manner, you can enhance its capabilities and adapt it to handle a wider range of file formats and transformation scenarios.

## Contributing

If you encounter any issues or have suggestions for improvements,
we welcome contributions from the community. Here's how you can contribute:

1. Fork the repository.
2. Make your changes.
3. Submit a pull request with a clear description of your changes and why they are needed.

## Support

For any questions or support regarding Fractor, please open an issue on GitHub. We'll do our best to assist you promptly.

## License

Fractor is licensed under the MIT License.

## Acknowledgments

Fractor wouldn't be possible without the amazing work of all the open source libraries we rely on.
We're grateful for their contributions to the PHP ecosystem.

-----

Thank you for using Fractor to streamline your software update process!
We hope it helps make your development workflow more efficient and enjoyable.
If you have any feedback or suggestions, we'd love to hear from you.

Happy coding! 🚀
