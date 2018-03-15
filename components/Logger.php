<?php

namespace components;


class Logger
{
    /**
     * @var string
     */
    private static $logFile = 'logs/log.txt';

    /**
     * @param bool|string $msg
     * @param bool|string $file
     * @param boolean $msgDate
     */
    public static function log($msg = false, $file = false, $msgDate = true)
    {

        if(is_bool($file) && $file === true) {
            self::$logFile = 'logs/' . date("Y-M-D") . '.txt';
        } elseif (is_string($file)){
            self::$logFile = 'logs/' . $file . '.txt';
        }


        if($msgDate)
            $msg = '[ ' . date('Y-m-d h:i:s') . ' ] ' . $msg;

        $msg = $msg . "\n";

        file_put_contents(self::$logFile, $msg, FILE_APPEND);
    }
}