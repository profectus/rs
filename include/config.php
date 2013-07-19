<?php
//základní nastavení projektu
defined("AUTOR_NAME") ? NULL : define("AUTOR_NAME", "esmedia.cz");
defined("AUTOR_DOMAIN") ? NULL : define("AUTOR_DOMAIN", "http://www.esmedia.cz");
defined("AUTOR_HOTLINE") ? NULL : define("AUTOR_HOTLINE", "Technická podpora: +420 608 303 909");

defined("PROJECT_TITLE") ? NULL : define("PROJECT_TITLE", "xxx.cz");
defined("PROJECT_NAME") ? NULL : define("PROJECT_NAME", "xxx.cz");
defined("PROJECT_DOMAIN") ? NULL : define("PROJECT_DOMAIN", "http://www.xxx.cz");
defined("PROJECT_EMAIL") ? NULL : define("PROJECT_EMAIL", "info@xxx.cz"); 
defined("PROJECT_META_DESC") ? NULL : define("PROJECT_META_DESC", ""); 
defined("PROJECT_META_KEY") ? NULL : define("PROJECT_META_KEY", ""); 

// připojení k databázi
defined("DB_HOST") ? NULL : define("DB_HOST", "127.0.0.1");
defined("DB_USER") ? NULL : define("DB_USER", "root");
defined("DB_PASS") ? NULL : define("DB_PASS", "");
defined("DB_NAME") ? NULL : define("DB_NAME", "nadacnifondjt.cz");
defined("DB_CHARACTER") ? NULL : define("DB_CHARACTER", "utf8");

// nastavení konstant chování systému
defined("CONST_MAX_DELAY_NOTIFICATION") ? NULL : define("CONST_MAX_DELAY_NOTIFICATION", "5000");
defined("CONST_MAX_DELAY_NOTIFICATION_CHAR") ? NULL : define("CONST_MAX_DELAY_NOTIFICATION_CHAR", "20");
defined("CONST_MIN_CHAR_LOGIN_PASSWORD") ? NULL : define("CONST_MIN_CHAR_LOGIN_PASSWORD", "5");

defined("INC_DIR") ? NULL : define("INC_DIR", "inc");
defined("DEBUGGER") ? NULL : define("DEBUGGER", TRUE);

mb_internal_encoding('UTF-8');

if (DEBUGGER) { 
	$debugArray = array("192.168.1.155","192.168.1.107","94.74.229.218","89.203.220.141","194.228.32.67","192.168.2.110");
} else { $debugArray = array(); }


require("functions.php"); // soubor obsahující funkce obsluhující jádro projektu
require("functions_local.php"); // soubor obsahující specifické funkce pro tento projekt

require ('nette.min.php');
require ('dibi.min.php');


use Nette\Diagnostics\Debugger;
Debugger::enable(); // aktivujeme Laděnku

$configurator = new Nette\Config\Configurator;
$configurator->setDebugMode($debugArray);
$configurator->enableDebugger(dirname(__DIR__).'/logs');
\Nette\Diagnostics\Debugger::$strictMode = FALSE;


// připojení k dibi
dibi::connect(array(
    'driver'   => 'mysql',
    'host'     => DB_HOST,
    'username' => DB_USER,
    'password' => DB_PASS,
    'database' => DB_NAME,
    'charset'  => 'utf8',
	 'profiler' => TRUE, // spustí profiler
));


$configurator->setTempDirectory(dirname(__DIR__).'/temp');
$configurator->createRobotLoader()->addDirectory(dirname(__DIR__).'/class')->register();
$container = $configurator->createContainer();
$httpRequest = $container->httpRequest; // http://doc.nette.org/cs/http-request-response
define("IS_AJAX",($httpRequest->isAjax())?1:0);

@session_start();

?>