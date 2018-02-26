<?php

namespace components;


use Exception;
use PDOException;
use app\models\User;
use app\models\Session;

class AuthUtil
{

    private $loginPath = '/login';
    private $defaultRedirect = 'https://www.google.com/';
    private $defaultSuccessRoute = 'admin_index';

    /**
     * @var array|boolean $user
     */
    private $user;

    public function __construct()
    {

        if(isset($_SESSION['user'])){
            $this->user = $_SESSION['user'];
        } elseif (isset($_COOKIE['user'])){
            $this->user = unserialize($_COOKIE['user']);
        } else {
            $this->user = false;
        }

    }

    /**
     * Try to authenticate user or return false
     *
     * @param array $user
     * @param mixed $redirectToRouteAfterSuccess
     * @return bool
     */
    private function auth($user, $redirectToRouteAfterSuccess = false)
    {
        try {

            if(Session::createSession($user)){

                setcookie('user', serialize($user), time() + 604800);

                $_SESSION['user'] = $user;

                if($redirectToRouteAfterSuccess)
                    return redirectToRoute($redirectToRouteAfterSuccess);

                return redirectToRoute($this->defaultSuccessRoute);
            }

        } catch (PDOException $e){
            Logger::log($e->getMessage());
            return false;
        }

        return false;
    }

    /**
     * Check if isset $this->user and validate hash
     *
     * @param string|boolean $role
     * @return bool
     */
    private function isAuth($role = false)
    {

        if(!$this->user)
            return false;

        if (!Session::validateHash($this->user))
            return false;

        if($role)
            if(!isset($_SESSION['role']) || $_SESSION['role'] !== $role)
                die('Access denied (role)');

        return true;
    }

    /**
     * Public function to check if user is authenticated
     *
     * @param string|boolean $role
     * @param string|boolean $routeIfAccessDenied
     * @return mixed
     */
    public function checkAuth($role = false, $routeIfAccessDenied = false)
    {
        if(!$this->isAuth($role)){
            if($routeIfAccessDenied)
                return redirectToRoute($routeIfAccessDenied);
            else
                return false;
        }

        return true;
    }

    /**
     * Login user
     *
     * @param string $login
     * @param string $password
     */
    public function login($login, $password)
    {
        if($this->isAuth())
            redirect($this->defaultRedirect);

        /**
         * @var array $userData
         */
        $userData = User::getUserHashByCredentials($login, $password);

        if($userData)
            $this->auth($userData);
    }

    /**
     * Unset session and redirect to login page
     */
    public function logout()
    {
        if($this->isAuth()){
            if($this->unsetSession())
                redirect($this->loginPath);
        } else
            redirect($this->loginPath);
    }

    /**
     * Register user
     *
     * @param string $username
     * @param string $password
     * @return mixed
     */
    public function register($username, $password)
    {
        $response = [];
        $response['errors'] = false;

        if(!User::checkExists($username)){
            try {
                $user = User::register($username, $password);

                if($user)
                    $this->login($username, $password);
            } catch (\PDOException $e) {
                return print_r($e->getMessage());
            }

        } else {
            $response['errors'] = 'Username already exists!';
        }

        return $response;
    }

    /**
     * Delete session info
     *
     * @return bool|mixed
     */
    private function unsetSession()
    {
        try {

            if($_SESSION['user']){

                if(isset($_COOKIE['user']) && $_COOKIE['user']){
                    setcookie('user', false, time() - 604800);
                    unset($_COOKIE['user']);
                }

                Session::deleteSession($_SESSION['user']);

                unset($_SESSION['user']);
            }

            return true;
        } catch (Exception $e){
            Logger::log($e->getMessage());
            return false;
        }
    }

}