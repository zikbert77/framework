<?php

namespace app;

use components\Db;

class Model
{

    /**
     * @var \PDO $db
     */
    protected static $db;

    /**
     * Set connection to database when create app\Controller
     */
    public static function connect()
    {
        if (!isset(self::$db))
            self::$db = Db::getConnection();
    }

}