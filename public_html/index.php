<?php

define('START_LOAD', microtime(true));

// inclusione dei metodi di inizializzazione
$private = dirname(__FILE__).'/private/';
include_once($private.'config/new_init.inc.php');

// eccezione per il channel di facebook
if ($_PAGE == 'channel.html') { include 'channel.php'; exit(); }

define('CONTENT', true);

// azioni valide
$validActions = unserialize(VALIDACTIONS);
if (isset($_REQUEST['action']) && in_array($_REQUEST['action'], $validActions)) {
	include $private.'actions'.BASEPATH.$_REQUEST['action'].'.php';
	exit();
}

// pagine valide
// imposto la homepage
if ($_PAGE === '' || !isset($_PAGE)) { include $private.'pages'.BASEPATH.'home.php'; exit(); }
$validPages = unserialize(VALIDPAGES);
if (in_array($_PAGE, $validPages)) {
	include $private.'pages'.BASEPATH.$_PAGE.'.php';
	exit();
} else {
	echo '404 index'; exit();
	header("Location: /error/404");	
	exit();
}

?>