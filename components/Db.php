<?php

namespace components;

use PDO;
use PDOException;

class Db {

    public static function getConnection(){

        $paramsPath = ROOT . '/app/config/db_params.php';
        $params = include($paramsPath);

        $dsn = sprintf( "mysql:host=%s;dbname=%s;charset=utf8", $params['host'], $params['db_name']);
        $opt = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $pdo = new PDO($dsn, $params['user'], $params['password'], $opt);
        } catch (PDOException $e) {
            die('Connecting failure: ' . $e->getMessage());
        }

        return $pdo;
    }
}