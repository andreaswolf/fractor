#!/usr/bin/env bash

set -x

TESTS_BASE_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}" )" >/dev/null && pwd)"
BASE_DIR="$TESTS_BASE_DIR/../"

cd $TESTS_BASE_DIR

rm -r composer.lock vendor || true
composer install

TEST_DIR=typo3-yaml

cd $TEST_DIR

[[ -d ./output/ ]] && rm -rf ./output/
cp -r fixtures/ output/

cd $TESTS_BASE_DIR
./vendor/bin/fractor process --quiet -c $TESTS_BASE_DIR/$TEST_DIR/fractor.php

# TODO remove -b once we keep the output format when re-writing the file
diff -rub $TEST_DIR/expected-output/ $TEST_DIR/output/
