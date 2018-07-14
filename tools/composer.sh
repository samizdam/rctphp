#!/usr/bin/env bash

docker run --rm --interactive --tty --init \
    --volume $PWD:/app \
    --user $(id -u):$(id -g) \
    composer $@