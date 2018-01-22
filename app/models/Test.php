<?php

namespace app\models;

use app\Model;

class Test extends Model
{

    public static function test()
    {

        $stmt = self::connect()->query("SELECT * FROM clicks");
        while ($row = $stmt->fetch())
        {
            print_r($row);
        }

        return true;
    }

}