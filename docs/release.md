# Fractor release howto

We use [https://github.com/symplify/monorepo-builder](symplify/monorepo-builder) for releasing new versions.

## How to release a new version

### Major releases

_to be defined_

### Minor releases

To release version 0.1.0, run this

    vendor/bin/monorepo-builder release v0.1
    vendor/bin/monorepo-builder bump-interdependency "^0.2"
    vendor/bin/monorepo-builder package-alias

**Important:** Due to [a bug](https://github.com/symplify/monorepo-builder/issues/77) in `symplify/monorepo-builder`,
we need to manually raise dependency versions and branch aliases after a minor release (by running the two additional commands.

`monorepo-builder` by default would also do that after each patchlevel release and this is not what we want).

### Patchlevel releases

To release 0.1.1, run

    vendor/bin/monorepo-builder release v0.1.1

These commands can be tested by appending `--dry-run`
