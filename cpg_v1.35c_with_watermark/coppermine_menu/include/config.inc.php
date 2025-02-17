<?php

// Coppermine configuration file

// MySQL configuration

// Pull e107 master from wherever it may be -- config.inc.php can be incorporated from various places
$class2="../class2.php";
if (!is_file($class2)) {
	$class2 = "../".$class2;
}

	@require_once($class2); // For update.php, which does not follow the CPG standard

/*
 * Silly safe mode:
 * NOTE: see /other folder for a 'mkdir' cgi script that works around safe mode on many systems
 * UNcomment the define() below if your server uses safe mode
 */
//define('SILLY_SAFE_MODE', 1);

global $mySQLserver;
global $mySQLprefix;
global $mySQLuser;
global $mySQLpassword;
global $mySQLdefaultdb;

$CONFIG['dbserver'] =                         $mySQLserver;        // Your databaseserver
$CONFIG['dbuser'] =                         $mySQLuser;        // Your mysql username
$CONFIG['dbpass'] =                          $mySQLpassword;        // Your mysql password
$CONFIG['dbname'] =                         $mySQLdefaultdb;        // Your mysql database name


// MySQL TABLE NAMES PREFIX
$CONFIG['TABLE_PREFIX'] =                $mySQLprefix."CPG_";


?>