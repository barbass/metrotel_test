<?php

define('ENVIRONMENT', isset($_SERVER['ENVIRONMENT']) ? $_SERVER['ENVIRONMENT'] : 'production');

$src_path = realpath(__DIR__.'/../src');
define('SRCPATH', $src_path);

$system_path = realpath(__DIR__.'/../system');
define('SYSTEMPATH', $system_path);

$config_path = realpath(__DIR__.'/../config');
define('CONFIGPATH', $config_path);

switch (ENVIRONMENT) {
	case 'development':
		error_reporting(-1);
		ini_set('display_errors', 1);
		break;
	case 'testing':
	case 'production':
		ini_set('display_errors', 0);
		error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE);
		break;

	default:
		header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
		echo 'Error ENVIRONMENT.';
		exit(1);
}

require_once(SYSTEMPATH.'/spl.php');
splAutoLoadRegister();

use Metrotel\Core;

$core = new Core();
$core->run();
