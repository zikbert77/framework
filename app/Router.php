<?php

namespace app;

use components\Logger;
use Exception;

class Router {

    private $routes;
    
    public function __construct(){

        $this->routes = include(ROOT . '/app/config/routes.php');
        arsort($this->routes);
    }
    
    private function getURI(){

        if(!empty($_SERVER['REQUEST_URI'])){
            $uri = trim($_SERVER['REQUEST_URI']);
        }
        
        return $uri ?? null;
    }
    
    public function run()
    {

        try {

            //Отримати строку запроса

            $uri = $this->getURI();

            //Перевірити наявність такого запросу в routes.php

            foreach ($this->routes as $uriPattern => $path) {

                //Зрівнюємо $uriPattern and $uri
                if (preg_match("~{$path['path']}~", $uri)) {

                    //Долучаємо внутрішній шлях із зовнішнього згідно за правилом

                    $internalRoute = preg_replace("~{$path['path']}~", $path['defaults'], $uri);

                    //Визначаємо який контроллер і екшн

                    $segments = explode('/', $internalRoute);

                    $controllerName = array_shift($segments) . 'Controller';

                    $actionName = ucfirst(array_shift($segments)) . 'Action';

                    $parametres = $segments;


                    /**
                     * Підключити файл класу-контролера
                     * Створити об'єкт, визвати екшн
                     **/

                    $controllerName = 'app\\controllers\\' . $controllerName;

                    if (class_exists($controllerName)) {

                        $controllerObject = new $controllerName;

                        if(!method_exists($controllerObject, $actionName)){
                            Logger::log('Action does not exists');
                            throw new Exception('Action ('. $actionName .') does not exists');
                        }

                        $result = call_user_func_array(array($controllerObject, $actionName), $parametres);

                    } else {
                        Logger::log('Controller ('. $controllerName .') not found');
                        throw new Exception('Controller not found');
                    }

                    if ($result != null) {
                        break;
                    } else {
                        Logger::log('Route not found!');
                        throw new Exception('Route not found!');
                    }

                }

            }

        } catch (Exception $e){
            Logger::log($e->getMessage());
            print_r($e->getMessage());
            return false;
        }

        return false;
    }  
}