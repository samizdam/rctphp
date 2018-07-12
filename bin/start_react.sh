#!/usr/bin/env bash
for i in {8082..8088};
do
    php src/react.php $i &
done