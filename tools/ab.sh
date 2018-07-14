#!/usr/bin/env bash

docker-compose run --rm --user $(id -u):$(id -g) \
		ab ab $@