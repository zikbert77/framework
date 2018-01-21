<?php

class Router{
    private $routes;
    
    public function __construct(){
        $routes_path = ROOT . '/app/config/routes.php';
        $this->routes = include($routes_path);
    }
    
    private function getURI(){
        if(!empty($_SERVER['REQUEST_URI'])){
            $uri = trim($_SERVER['REQUEST_URI'], '/');
        }
        
        return $uri;
    }
    
    public function run(){
       //Отримати строку запроса
        
        $uri = $this->getURI();
        
       //Перевірити наявність такого запросу в routes.php
        
        foreach($this->routes as $uriPattern => $path){
            
            //Зрівнюємо $uriPattern and $uri
            if(preg_match("~$uriPattern~", $uri)){
                //Долучаємо внутрішній шлях із зовнішнього згідно за правилом
                
                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);
                
                //Визначаємо який контроллер і екшн
                
                $segments = explode('/', $internalRoute);
                
                $controllerName = array_shift($segments).'Controller';

                $actionName = 'action'.ucfirst(array_shift($segments));

                $parametres = $segments;

        
               //Підключити файл класу-контролера

                $controllerFile = ROOT . '/app/controllers/' . $controllerName . '.php';

                if(file_exists($controllerFile)){
                    include_once($controllerFile);
                } else {
                    throw new Exception("Controller not found");
                }

               //Створити об'єкт, визвати екшн

                $controllerObject = new $controllerName;

                $result = call_user_func_array(array($controllerObject, $actionName), $parametres);

                if($result != null){
                    break;
                }
        
            }
        }
            
    }  
}