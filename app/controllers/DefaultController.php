<?php

namespace app\controllers;

use core\framework\main\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('index.php');
    }
}