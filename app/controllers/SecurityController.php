<?php

namespace app\controllers;


use app\Controller;
use components\Logger;

class SecurityController extends Controller
{

    /**
     * SecurityController constructor
     *
     * Check if user not authenticated
     * If user authenticated redirect to homepage route
     *
     */
    public function __construct()
    {
        parent::__construct();

        if($this->auth->checkAuth())
            return redirectToRoute('homepage');
    }

    /**
     * Trying to log in User
     *
     * @return mixed
     */
    public function loginAction()
    {
        if (!isset($_POST['login-submit']))
            return $this->render('AuthUtil/login.php');

        $u_name = trim(htmlspecialchars($_POST['lg_username']));
        $u_pass = md5(trim(htmlspecialchars($_POST['lg_password'])));
        $remember = isset($_POST['lg_remember'])? $_POST['lg_remember'] : false;

        try {
            $this->auth->login($u_name, $u_pass);
        } catch (\Exception $e){
            Logger::log($e->getMessage());
        }

        return redirect('/admin');
    }

    /**
     * Log out user
     * Unset sessions and cookies
     *
     * @return mixed
     */
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