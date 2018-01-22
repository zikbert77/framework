<?php

namespace App;

use Exception;

class Controller
{
    protected function redirectToRoute($path)
    {
        header("Location: $path");
        return true;
    }

    protected function render($path)
    {
        try {
            $filePath = ROOT . '/views/' . $path;

            if (file_exists($filePath))
                require_once $filePath;
            else
                throw new Exception("View not found");
        } catch (Exception $e){
            print_r($e->getMessage());
            return false;
        }
        return true;
    }
}