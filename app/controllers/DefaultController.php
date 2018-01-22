<?php

namespace app\controllers;

use app\Controller;
use componenets\Db;

class DefaultController extends Controller
{
    public function actionIndex(){

        Db::getConnection();

        return $this->render('index.php');
    }
}