<?php

namespace app\models;


use app\Model;

class User extends Model
{

    /**
     * @param string $username
     * @param string $password
     * @return string|boolean
     */
    public static function getUserHashByCredentials($username, $password)
    {
        $stmt = self::$db->prepare("SELECT id, username, password FROM users WHERE username = :username AND password = :password LIMIT 1");

        if ($stmt->execute([
            'username' => $username,
            'password' => $password
        ])) {
            $user = $stmt->fetch();
            if($stmt->rowCount() == 0)
                die('User not found');

            $result['user_id'] = $user['id'];
            $result['hash'] = md5($user['username'] . $user['password'] . $_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']);
        }

        return $result ?? false;
    }

    /**
     * @param $username
     * @return bool
     */
    public static function checkExists($username)
    {
        $stmt = self::$db->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");

        if($stmt->execute([
            'username' => $username
        ])) {
            if ($stmt->rowCount() === 1)
                return true;
        }

        return false;
    }

    public static function register($username, $password)
    {

        $stmt = self::$db->prepare("INSERT INTO users(username, password) VALUES(:username, :password)");

        if($stmt->execute([
            'username' => $username,
            'password' => $password
        ]))
            return true;

        return false;
    }

}