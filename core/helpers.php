<?php

/**
 * Write your own functions and use it anywhere in your beautiful code.
*/

function dump($var)
{
    echo '<pre style="background-color: black; color: darkorange; padding: 5px;">';
    print_r($var);
    echo '</pre>';
}

function path($routeName)
{
    try {
        $routes = include(ROOT . '/app/config/routes.php');

        if (array_key_exists($routeName, $routes))
            return '/' . $routes[$routeName]['path'];

        throw new Exception(sprintf('Route %s not exist', $routeName));
    } catch (Exception $e){
        return print_r($e->getMessage());
    }
}