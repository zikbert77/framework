<?php

namespace app\controllers;


use app\Controller;
use components\Logger;

class SecurityController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        if($this->auth->checkAuth())
            return redirectToRoute('homepage');
    }

    public function loginAction()
    {
        if (!isset($_POST['login-submit']))
            return $this->render('AuthUtil/login.php');

        $u_name = trim(htmlspecialchars($_POST['lg_username']));
        $u_pass = trim(htmlspecialchars($_POST['lg_password']));
        $remember = isset($_POST['lg_remember'])? $_POST['lg_remember'] : false;

        try {
            if ($this->auth->login($u_name, md5($u_pass)))
                return redirectToRoute('admin_index');
        } catch (\Exception $e){
            Logger::log($e->getMessage());
        }

        return redirect('/admin');
    }

    public function logoutAction()
    {
        try {
            $this->auth->logout();
        } catch (\Exception $e) {
            Logger::log($e->getMessage());
        }

        return redirectToRoute('login');
    }
}