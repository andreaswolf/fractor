# Fractor for Fluid Templates

FileProcessor for Fluid templates.

## Installation

```bash
composer require a9f/fractor-fluid --dev
```

## Configuration

All rules must implement the a9f\FractorFluid\Contract\FluidFractorRule interface.
The rule will be tagged with 'fractor.fluid_rule' and be injected in the FluidFileProcessor.
