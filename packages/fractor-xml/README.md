# Fractor for XML files

FileProcessor for XML files.

## Installation

```bash
composer require a9f/fractor-xml --dev
```

## Configuration

All rules must implement the a9f\FractorXml\Contract\XmlFractor interface.
The rule will be tagged with 'fractor.xml_rule' and be injected in the XmlFileProcessor.
