<?php

//namespace App\Controller;

class DefaultController
{
    public function actionIndex(){

        require_once(ROOT . '/views/index.php');
        return true;
    }
}