<?php
$zonahoraria = date_default_timezone_get();
date_default_timezone_set($zonahoraria);

define('MySQL_HOST', 'localhost');
define('MySQL_USER', 'dstswitch');
define('MySQL_PASS', 'fr33t3chs0lu710ns');

define('AMI_USER', 'ftsb1ll1n9');
define('AMI_PASS', 'c0nqu33st4sFreetech');

define('MySQL_ELX_HOST', 'localhost');
define('MySQL_ELX_USER', 'dstswitch');
define('MySQL_ELX_PASS', 'fr33t3chs0lu710ns');

include_once '/var/lib/asterisk/agi-bin/php-asmanager.php';
include_once '/var/lib/asterisk/agi-bin/phpagi.php';