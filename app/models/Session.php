<?php

namespace app\models;

use app\Model;

class Session extends Model
{

    /**
     * @param $user
     * @return bool
     */
    private static function checkSessionExists($user)
    {
        $stmt = self::$db->prepare("SELECT * FROM sessions WHERE hash = :hash AND user_id = :user_id LIMIT 1");

        if($stmt->execute([
            'hash' => $user['hash'],
            'user_id' => $user['user_id']
        ])){
            if ($stmt->rowCount() == 1)
                return true;
        }
        return false;
    }

    public static function createSession($user)
    {
        if (self::checkSessionExists($user))
            return true;

        $stmt = self::$db->prepare("INSERT INTO sessions (user_id, ip, user_agent, hash, time) VALUES(:user_id, :ip, :user_agent, :hash, :extime)");

        if($stmt->execute([
            'user_id'       => $user['user_id'],
            'ip'            => $_SERVER['REMOTE_ADDR'],
            'user_agent'    => $_SERVER['HTTP_USER_AGENT'],
            'hash'          => $user['hash'],
            'extime'        => date('Y-m-d h:i:s', strtotime('next week'))
        ])){
            return true;
        } else
            return false;
    }

    public static function deleteSession($user)
    {
        $stmt = self::$db->prepare("DELETE FROM sessions WHERE hash = :hash AND user_id = :user_id LIMIT 1");

        if($stmt->execute([
            'hash' => $user['hash'],
            'user_id' => $user['user_id']
        ])) {

            return true;
        }

        return false;
    }

    /**
     * @param array $session_user
     * @return bool
     */
    public static function validateHash($session_user)
    {

        $stmt = self::$db->prepare("SELECT user_id FROM sessions WHERE hash = :hash AND user_id = :user_id AND time > :exttime LIMIT 1");

        if($stmt->execute([
            'hash' => $session_user['hash'],
            'user_id' => $session_user['user_id'],
            'exttime' => date('Y-m-d h:i:s')
        ])) {

            $user_id = $stmt->fetch();

            if(is_int($user_id['user_id'])){
                $stmt = self::$db->prepare("SELECT * FROM users WHERE id = :user_id");

                if($stmt->execute([
                    'user_id' => $user_id['user_id']
                ])){
                    $user = $stmt->fetch();

                    $hash_from_db = md5($user['username'] . $user['password'] . $_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']);

                    if ($session_user['hash'] === $hash_from_db)
                        return true;
                }
            }
        }

        return false;
    }

}