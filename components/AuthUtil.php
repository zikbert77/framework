<?php

namespace components;


use Exception;
use app\models\User;
use app\models\Session;

class AuthUtil
{

    private $loginPath = '/login';
    private $logoutPath = '/logout';
    private $registerPath = '/register';

    /**
     * @var bool $isAuth
     */
    private $isAuth;

    /**
     * @var array|boolean $user
     */
    private $user;

    public function __construct()
    {
        $this->isAuth   = $_SESSION['security_check'] ?? false;
        $this->user     = $_SESSION['user'] ?? false;
    }

    /**
     * @param array $user
     * @return bool
     */
    private function auth($user)
    {
        try {

            Session::createSession($user);

        } catch (\PDOException $e){
            return print_r($e->getMessage());
        }

        $_SESSION['security_check'] = true;
        $_SESSION['user'] = $user;

        return true;
    }

    /**
     * @return bool
     */
    private function isAuth()
    {
        if(!$this->user || !Session::validateHash($this->user['hash']))
            return false;

        return true;
    }


    /**
     * @param string $login
     * @param string $password
     */
    public function login($login, $password)
    {
        if($this->isAuth())
            header("Location: $this->logoutPath");

        /**
         * @var array $userData
         */
        $userData = User::getUserHashByCredentials($login, $password);

        if($userData){

            $this->auth($userData);

        }

    }

    /**
     * Unset session and redirect to login page
     */
    public function logout()
    {
        if($this->isAuth()){
            if($this->unsetSession())
                header("Location: $this->loginPath");
        } else
            header("Location: $this->loginPath");
    }

    /**
     * @param string $username
     * @param string $password
     * @return mixed
     */
    public function register($username, $password)
    {
        $password = md5($password);

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
     * @return bool|mixed
     */
    private function unsetSession()
    {
        try {

            $_SESSION['security_check'] = false;
            unset($_SESSION['user']);

            return true;
        } catch (Exception $e){
            return print_r($e->getMessage());
        }
    }

}