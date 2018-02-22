<?php

namespace components;


class Logger
{
    private static $logFile = 'logs/log.txt';

    /**
     * @param bool|string $msg
     */
    public static function log($msg = false)
    {
        $msg = '[ ' . date('Y-m-d h:i:s') . ' ] ' . $msg . "\n";

        file_put_contents(self::$logFile, $msg, FILE_APPEND);
    }
}