<?php

    //FRONT CONTROLLER

    //1. Загальні налаштування
  
//На момент розробки, показує помилки
ini_set('display_errors',1);
error_reporting(E_ALL);

    //2. Підключення файлів системи

$dir_name = str_replace('\\','/', dirname(__FILE__));

define('ROOT', $dir_name);

require_once(ROOT . '/app/Router.php');

    //3. З'єднання з БД
require_once(ROOT . '/components/Db.php');

    //4. Виклик Routers

$router = new Router;
$router->run();