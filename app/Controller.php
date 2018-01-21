<?php
namespace App;


class Controller
{
    protected function redirectToRoute($path)
    {
        header("Location: $path");
        return true;
    }

    protected function render($path)
    {
        $filePath = ROOT . '/views/' . $path;

        if (file_exists($filePath))
            require_once $filePath;
        else
            throw new \Exception("Views not found");

        return true;
    }
}