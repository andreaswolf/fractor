# Fractor for YAML files

FileProcessor for YAML files.

## Installation

```bash
composer require a9f/fractor-yaml --dev
```

## Configuration

All rules must implement the a9f\FractorYaml\Contract\YamlFractorRule interface.
The rule will be tagged with 'fractor.yaml_rule' and be injected in the YamlFileProcessor.
