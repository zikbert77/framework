<?php

namespace app\controllers;

use app\Controller;

class DefaultController extends Controller
{
    public function indexAction(){

        return $this->render('index.php');
    }
}