#!/usr/bin/env bash

if [ ! -d /app/.planb ]; then
    cp -R /robo/.planb/ /app/.planb/
fi

if [ ! -f /app/RoboFile.php ]; then
    cp /robo/RoboFile.php /app/RoboFile.php
fi

robo $@
exit $?
