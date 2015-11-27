<?php
header('Content-Type: text/html; charset=utf-8');

session_start();

!defined('PROJECT_ROOT_DIR') ? define('PROJECT_ROOT_DIR', dirname(__FILE__)) : ''; // define project root if not defined
!defined('APPLICATION_ROOT_DIR') ? define('APPLICATION_ROOT_DIR', PROJECT_ROOT_DIR . DIRECTORY_SEPARATOR . 'application') : ''; // define application root paths
!defined('ADMIN_ROOT_DIR') ? define('ADMIN_ROOT_DIR', PROJECT_ROOT_DIR . DIRECTORY_SEPARATOR . 'administration') : ''; // define admin root paths

!defined('SITE_ROOT_URI') ? define('SITE_ROOT_URI', 'http://' .$_SERVER['HTTP_HOST']) : ''; //
!defined('APPLICATUIN_ROOT_URI') ? define('APPLICATUIN_ROOT_URI', SITE_ROOT_URI . '/application') : ''; // 

require_once PROJECT_ROOT_DIR . '/libraries/loader.php';

Libraries_Loader::getInstance()->register();

Libraries_Event::registerEvents(ADMIN_ROOT_DIR);
Libraries_Event::registerEvents(APPLICATION_ROOT_DIR);

$enviorement = Libraries_Environment_Factory::getEnvironment();
$request = Libraries_Request::getInstance(); // only one request per call
$router = Libraries_Router::getInstance();

$router->route($request);