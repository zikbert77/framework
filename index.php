<?php

use app\Router;

//1. General settings

session_start();

/**
 * Show exceptions in dev environment
 */
ini_set('display_errors',1);
error_reporting(E_ALL);

/**
 * Set project path in constant ROOT
 */
define('ROOT', str_replace('\\','/', dirname(__FILE__)));

//2. System file include

/**
 * Helpers functions
*/
require_once ROOT . '/core/helpers.php';

/**
 * PSR-4 classes autoload
*/
require ROOT . '/vendor/autoload.php';

//3. Connect to database
require_once(ROOT . '/components/Db.php');

//4. Start routing
$router = new Router;
$router->run();