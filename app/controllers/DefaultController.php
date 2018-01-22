<?php

namespace app\controllers;

use app\Controller;
use app\models\Test;

class DefaultController extends Controller
{
    public function actionIndex(){

        Test::test();

        return $this->render('index.php');
    }
}