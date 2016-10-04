<?php
$zonahoraria = date_default_timezone_get();
date_default_timezone_set($zonahoraria);

define('MySQL_HOST', '');
define('MySQL_USER', '');
define('MySQL_PASS', '');

define('AMI_USER', '');
define('AMI_PASS', '');

define('MySQL_ELX_HOST', ');
define('MySQL_ELX_USER', '');
define('MySQL_ELX_PASS', '');

include_once '/var/lib/asterisk/agi-bin/php-asmanager.php';
include_once '/var/lib/asterisk/agi-bin/phpagi.php';