<?php

namespace components;


class Logger
{
    private static $logFile = 'logs/log.txt';

    /**
     * @param bool|string $msg
     * @param bool|string $file
     */
    public static function log($msg = false, $file = false)
    {

        if(is_bool($file)) {
            self::$logFile = 'logs/' . date("Y-M-D") . '.txt';
        } elseif (is_string($file)){
            self::$logFile = 'logs/' . $file . '.txt';
        }

        $msg = '[ ' . date('Y-m-d h:i:s') . ' ] ' . $msg . "\n";

        file_put_contents(self::$logFile, $msg, FILE_APPEND);
    }
}