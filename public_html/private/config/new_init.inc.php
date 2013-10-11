<?php

session_start();

// content type
header( "Cache-Control: no-cache, must-revalidate" );
header('Content-Type: text/html; charset=utf-8'); 

// url rewrite
$basepath = '/';

$PARAM = substr($_SERVER['REQUEST_URI'],strlen($basepath));
$PARAM = explode("?",$PARAM);
$_VARS = array_filter(explode("/",$PARAM[0]),'filter_url'); function filter_url($var) { return (bool)(trim($var) != ''); }
$_HTTP = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 'https://' : 'http://';
define('HTTP', $_HTTP);

define('BASEPATH', $basepath);
define('SCRT', " .asdflkASLlkfj");
define('SESSIONTIME', 30);					// giorni durata cookie

$_PAGE = array_shift($_VARS);

// variabili di connessione
include_once(dirname(__FILE__).'/../classes/autoload.php');
include_once(dirname(__FILE__).'/new_db.inc.php');

// inizializzo il database
$db = new dbman(DBHOST, DBUSER, DBPASS, DBNAME);
$db->setDebug(DEBUG);
// imposto il charset per l'inserimento dei testi durante le query
$sql[] = "SET CHARACTER_SET_RESULTS=utf8";
$sql[] = "SET NAMES utf8";	
$db->do_queries($sql);
unset($sql);

// inizializzo classi
$tools = new Tools($db);

// caricamento pagine
include_once(dirname(__FILE__).'/pages.inc.php');