<?php
error_reporting(E_ALL);
/**
 * Application path
 */
define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));
/**
 * Application enviroment
 */
define('APPLICATION_ENV', 'development');

require_once APPLICATION_PATH . '/models/Rabbit.php';
/**
 * /Ensure library/ is on include_path
 */
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path()
)));

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);
$application->getBootstrap()->bootstrap();

$config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV);

//Zend_Debug::dump($config);

$r = new Application_Model_Rabbit($config->rabbitmq);
$r->consumer();