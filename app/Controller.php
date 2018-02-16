<?php

namespace App;

use Exception;
use app\Model;

class Controller
{

    /**
     * Controller constructor.
     * Set connection to database
     */
    public function __construct()
    {
        Model::connect();
    }

    /**
     * @param $url string
     */
    protected function redirect($url){
        return header("Location: $url");
    }

    /**
     * @param string $path
     * @param array $optionsArray
     */
    protected function redirectToRoute($path, $optionsArray = [])
    {
        $newpath = path($path, $optionsArray);

        return header("Location: $newpath");
    }

    /**
     * @param string $path
     * @param array $variables
     * @return mixed
     */
    protected function render($path, $variables = [])
    {
        try {
            $filePath = ROOT . '/views/' . $path;

            if (file_exists($filePath)){
                if (!empty($variables))
                    extract($variables);
                return require_once $filePath;
            } else {
                throw new Exception("View not found");
            }
        } catch (Exception $e){
            return print_r($e->getMessage());
        }
    }
}