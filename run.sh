#!/bin/bash
WORK_DIR=`dirname $0`
HOME=$(readlink -f $(dirname $0))
# PHP="/home/users/chenghaofeng/athena/php/bin/php -c /home/users/chenghaofeng/athena/php/etc/php.ini"
PHP="/home/ching/athena/php/bin/php -c /home/ching/athena/php/etc/php.ini"
export CLI_CRON_CONF="${HOME}/conf/CLI_SERVER_CONFIG"
if [ $# -lt 1 ]; then
    echo 'too few param!';
    exit 1
fi
filename=$1".php"
if [ ! -e ${WORK_DIR}/script/${filename} ]; then
    echo "entry file dosen't exists."
    exit 1
fi
cd ${WORK_DIR}
shift
${PHP} script/${filename} $@

