<?php

// subdomain
$domain_part = explode(".",$_SERVER['HTTP_HOST']);
if (count($domain_part)==2) { array_unshift($domain_part, null); }
define('DOMAIN_PART',serialize($domain_part));

// DATABASE
// locale
if ($_SERVER['HTTP_HOST'] == 'bikesharingstatus.pug') {
		
	define('DBHOST', 'localhost');
	define('DBUSER', 'root');
	define('DBPASS', 'scembola86');
	define('DBNAME', 'bikesharingstatus');	
	define('DOMAIN', 'bikesharingstatus.pug');

	$debug = 1;
	
}

/*
// stage
if ($domain_part[0] == 'stage') {

	ini_set('session.cookie_domain', 'stage.20lin.es');

	define('DBHOST', 'localhost');
	define('DBUSER', 'root');
	define('DBPASS', 'ViaSile41');
	define('DBNAME', 'stage');	
	define('DOMAIN', 'stage.20lin.es');

	define('MC_HOST', 'localhost');
	define('MC_PORT', '11212');
	define('MC_EXPIRE', '600');
	
	$debug = 1;

}
*/

/*
if ($domain_part[1] = 'bikesharingstatus') {

	ini_set('session.cookie_domain', '.bikesharingstatus.com');
		
	define('DBHOST', 'localhost');
	define('DBUSER', 'root');
	define('DBPASS', 'ViaSile41');
	define('DBNAME', 'social');	
	define('DOMAIN', 'bikesharingstatus.com');

	define('MC_HOST', 'localhost');
	define('MC_PORT', '11211');
	define('MC_EXPIRE', '600');
	
	$debug = 0;
	
}
*/

if (isset($_GET['debug'])) $debug = 1;

define('DEBUG', $debug);
