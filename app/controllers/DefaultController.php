<?php

namespace app\controllers;

use app\Controller;

class DefaultController extends Controller
{
    public function actionIndex(){

        return $this->render('index.php');
    }
}