<?php

namespace App;

use Exception;

class Controller
{
    protected function redirect($url){
        return header("Location: $url");
    }

    protected function redirectToRoute($path, $optionsArray = [])
    {
        $newpath = path($path, $optionsArray);

        return header("Location: $newpath");
    }

    protected function render($path)
    {
        try {
            $filePath = ROOT . '/views/' . $path;

            if (file_exists($filePath))
                return require_once $filePath;
            else
                throw new Exception("View not found");
        } catch (Exception $e){
            return print_r($e->getMessage());
        }
    }
}