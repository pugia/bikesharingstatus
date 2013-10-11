<?php

// setto gli errori visibili in debug
if (DEBUG) {
	ini_set('display_errors', '1');
	error_reporting(E_ALL);
} else {
	ini_set('display_errors', '0');
	error_reporting(0);
}


// registrazione
define('ACTIVATION_TIME', '2');				// giorni validi per l'attivazione
define('TIME_BETWEEN_WRITE', '60');		// secondi tra un nodo e l'altro

// auth facebook
define('FB_APPID', '245586205515619');
define('FB_APPSCRT', 'dac56b15204e2980b8721c97a6a2947a');
define('FB_APPSCOPE', 'user_about_me, email, user_birthday');
define('FB_CALLBACK', 'http://'.LANG_CODE.'.20lines.com/login/fb');

// auth twitter
// TWITTER
define('TW_KEY', 'ZQPLiu6HJ0htrZhHRpToA');
define('TW_SECRET', 'WgrM6PDJ61riqOtC7dvBoh33SyVAFMN3CKoTFueQDw');
define('TW_TOKEN', '464785828-zDUUt9atIEP117hAZVHfUiyMqv0fFVqTIkvWSUNF');
define('TW_TOKEN_SECRET', 'Em5MRYzmOR0twcIUeFz9JLpP9RoA6qwdLgm2XSTEWA');
define('TW_CALLBACK', 'http://'.LANG_CODE.'.20lines.com/login/tw');

// Mailchimp
define('MCAPI', '74dd6262da718e1acd83879cb531d3da-us6');
define('MCLIST', 'a32e417a9c');

// Mandrill
define('MANDRILL_KEY', 'Vz7qjiwfdKMpRvLgxdbpiA');

// CONTEXT
define('CONTEXT', serialize(array('web', 'mobile', 'pro')));

// SERVICE
define('MENU_ITEM', 6);
