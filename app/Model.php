<?php

namespace app;

use components\Db;

class Model
{

    protected static $db;

    protected static function connect()
    {
        if (!isset(self::$db))
            self::$db = Db::getConnection();

        return self::$db;
    }

}