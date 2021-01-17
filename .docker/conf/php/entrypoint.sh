#!/bin/bash

# Start the run once job.
echo "Docker container has been started"
declare -p | grep -Ev 'BASHOPTS|BASH_VERSINFO|EUID|PPID|SHELLOPTS|UID' > /container.env

# Setup a cron schedule
echo "SHELL=/bin/bash
BASH_ENV=/container.env
0 */1 * * * php /var/www/html/bin/console app:weather-api-get >> /var/log/cron.log 2>&1
# This extra line makes it a valid cron" > weatherCronJob.txt

crontab weatherCronJob.txt
cron -f &
docker-php-entrypoint php-fpm

