<?php

namespace app;

use Exception;

class Router {

    private $routes;
    
    public function __construct(){

        $this->routes = include(ROOT . '/app/config/routes.php');
    }
    
    private function getURI(){

        if(!empty($_SERVER['REQUEST_URI'])){
            $uri = trim($_SERVER['REQUEST_URI'], '/');
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

                    $actionName = 'action' . ucfirst(array_shift($segments));

                    $parametres = $segments;


                    /**
                     * Підключити файл класу-контролера
                     * Створити об'єкт, визвати екшн
                     **/

                    $controllerName = 'app\\controllers\\' . $controllerName;

                    if (class_exists($controllerName)) {

                        $controllerObject = new $controllerName;

                        if(!method_exists($controllerObject, $actionName)){
                            throw new Exception('Action does not exists');
                        }

                        $result = call_user_func_array(array($controllerObject, $actionName), $parametres);

                    } else {
                        throw new Exception('Controller not found');
                    }

                    if ($result != null) {
                        break;
                    }

                }

                throw new Exception('Route not found!');
            }
        } catch (Exception $e){
            print_r($e->getMessage());
            return false;
        }
    }  
}