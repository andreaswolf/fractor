# Fractor release howto

We use [https://github.com/symplify/monorepo-builder](symplify/monorepo-builder) for releasing new versions.

## How to release a new version

To release version 0.1.0, run this

    vendor/bin/monorepo-builder release v0.1

To release 0.1.1, run

    vendor/bin/monorepo-builder release v0.1.1

These commands can be tested by appending `--dry-run`