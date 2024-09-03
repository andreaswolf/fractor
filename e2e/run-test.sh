#!/usr/bin/env bash

set -x

TESTS_BASE_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}" )" >/dev/null && pwd)"
BASE_DIR="$TESTS_BASE_DIR/../"

cd $TESTS_BASE_DIR

rm -r composer.lock vendor || true
composer install

ALL_TESTS="no-config-file typo3-typoscript typo3-xml typo3-yaml"
TESTS_TO_RUN=${1:-$ALL_TESTS}

echo "Running tests: " $TESTS_TO_RUN

for TEST_DIR in $TESTS_TO_RUN
do
    set +x
    echo
    echo "############################################################"
    echo "#"
    echo "# Running test in $TEST_DIR/"
    echo "#"
    echo "############################################################"
    echo
    set -x

    # remove output from a previous run, if any
    [[ -f $TEST_DIR/output.txt ]] && rm $TEST_DIR/output.txt
    [[ -d $TEST_DIR/result/ ]] && rm -rf $TEST_DIR/result/
    # copy over our fixture to the path that Fractor will run in
    cp -r $TEST_DIR/fixtures/ $TEST_DIR/result/

    CONFIG_FILE=""
    if [ -f $TESTS_BASE_DIR/$TEST_DIR/fractor.php ]
    then
        CONFIG_FILE="-c $TESTS_BASE_DIR/$TEST_DIR/fractor.php"
    fi

    ./vendor/bin/fractor process $CONFIG_FILE > $TEST_DIR/output.txt

    set +x
    echo
    echo "############################################################"
    echo "# Comparing Fractor result against expected result"
    echo
    set -x

    # TODO remove -b once we keep the output format when re-writing the file
    diff -rub --color=auto $TEST_DIR/expected-result/ $TEST_DIR/result/

    set +x
    echo
    echo "############################################################"
    echo "# Comparing Fractor CLI output against expected output"
    echo
    set -x

    diff -u --ignore-trailing-space --color=auto $TEST_DIR/expected-output.txt $TEST_DIR/output.txt
done
