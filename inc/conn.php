<?php
session_start();

// Get config vars from ini file
$configvars = parse_ini_file("config/field-test.ini", true);

mysql_connect($configvars["database"]["dbhost"], $configvars["database"]["dbuser"], $configvars["database"]["dbpass"]) or die(mysql_error());
mysql_select_db($configvars["database"]["dbname"]) or die(mysql_error());

?>
