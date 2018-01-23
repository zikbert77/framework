<?php

namespace App;

use Exception;

class Controller
{
    protected function redirectToRoute($path)
    {
        return header("Location: $path");
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