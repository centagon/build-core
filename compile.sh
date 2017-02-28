#!/bin/bash

pushd src

gulp --production
GULP_STATUS=$?
popd

exit $GULP_STATUS