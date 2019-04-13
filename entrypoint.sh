#!/usr/bin/env bash

if [ ! -d /app/.planb ]; then
    cp -R /main/.planb/ /app/.planb/
fi

if [ ! -f /app/RoboFile.php ]; then
    cp /main/RoboFile.php /app/RoboFile.php
fi

/main/bin/robo $@
exit $?