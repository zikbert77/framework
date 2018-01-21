<?php
//namespace App\Controller;

use App\Controller;
require_once ROOT . '/app/Controller.php';


class DefaultController extends Controller
{
    public function actionIndex(){

        return $this->render('test/index.php');
    }
}