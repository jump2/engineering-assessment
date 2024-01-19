#!/bin/bash
bashdir=`cd $(dirname $0); pwd -P`
/usr/bin/composer install --working-dir=$bashdir
/usr/local/bin/php $bashdir/command/migrate.php
/usr/local/bin/php $bashdir/index.php
