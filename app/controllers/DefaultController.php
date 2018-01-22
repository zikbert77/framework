<?php

namespace app\controllers;

use app\Controller;
use components\Db;

class DefaultController extends Controller
{
    public function actionIndex(){

        Db::getConnection();

        return $this->render('index.php');
    }
}