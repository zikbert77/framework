<?php

namespace App;

use app\Model;
use Exception;
use components\AuthUtil;

class Controller
{
    /**
     * @var AuthUtil $auth
     */
    protected $auth;

    /**
     * Controller constructor.
     * Set connection to database
     */
    public function __construct()
    {
        Model::connect();

        $this->auth = new AuthUtil();
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